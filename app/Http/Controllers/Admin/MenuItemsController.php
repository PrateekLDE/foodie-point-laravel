<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * MenuItemsController
 *
 * Handles all CRUD for the owner's daily menu items.
 * 
 */
class MenuItemsController extends Controller
{
    /**
     * Show today's menu items 
     */
    public function index(Request $request)
    {
        $now = Carbon::today()->toDateString();
        $date = $request->get('date', $now);

        $menuItems = MenuItem::forDate($date)
            ->get()
            ->groupBy('meal_period');

        // Get recent items to populate the autocomplete suggestions
        $suggestedItems = MenuItem::select('name', 'price', 'description', 'meal_period')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('name');

        return view('admin.menu-items.index', [
            'menuItems'   => $menuItems,
            'date'        => $date,
            'isToday'     => $date === $now,
            'mealPeriods' => MenuItem::MEAL_PERIODS,
            'suggestedItems' => $suggestedItems,
        ]);
    }

    /**
     * Store a new menu item.
     * Defaults date to today so the owner just fills name + price and taps Save.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'        => 'required|date',
            'meal_period' => 'required|in:' . implode(',', array_keys(MenuItem::MEAL_PERIODS)),
            'name'        => [
                'required',
                'string',
                'max:100',
                Rule::unique('menu_items')->where(function ($query) use ($request) {
                    return $query->where('date', $request->input('date'))
                        ->where('meal_period', $request->input('meal_period'));
                }),
            ],
            'description' => 'nullable|string|max:500',
            'price'       => 'nullable|numeric|min:0|max:9999',
            'sort_order'  => 'nullable|integer|min:0',
        ], [
            'name.required'        => 'Please enter the name of the menu item.',
            'name.unique'          => 'This item is already on the menu for this date and meal period.',
            'price.numeric'        => 'Price should be a number like 12.99.',
            'meal_period.required' => 'Please choose which meal this menu item is for.',
        ]);

        // Default sort to end of list for this date+period
        if (empty($validated['sort_order'])) {
            $validated['sort_order'] = MenuItem::where('date', $validated['date'])
                ->where('meal_period', $validated['meal_period'])
                ->count();
        }

        MenuItem::create($validated);

        return redirect()
            ->route('admin.menu-items.index', ['date' => $validated['date']])
            ->with('success', '✓ Menu item added!');
    }

    /**
     * Show edit form for a single menu item.
     */
    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu-items.edit', [
            'menuItem'    => $menuItem,
            'mealPeriods' => MenuItem::MEAL_PERIODS,
        ]);
    }

    /**
     * Update a menu item.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'meal_period' => 'required|in:' . implode(',', array_keys(MenuItem::MEAL_PERIODS)),
            'name'        => [
                'required',
                'string',
                'max:100',
                Rule::unique('menu_items')->ignore($menuItem->id)->where(function ($query) use ($request, $menuItem) {
                    return $query->where('date', $menuItem->date->toDateString())
                                 ->where('meal_period', $request->input('meal_period'));
                }),
            ],
            'description' => 'nullable|string|max:500',
            'price'       => 'nullable|numeric|min:0|max:9999',
            'sort_order'  => 'nullable|integer|min:0',
        ], [
            'name.unique' => 'Another item with this name already exists for this date and meal period.',
        ]);

        $menuItem->update($validated);

        return redirect()
            ->route('admin.menu-items.index', ['date' => $menuItem->date->toDateString()])
            ->with('success', '✓ Menu item updated!');
    }

    /**
     * Soft-toggle availability without deleting.
     * Useful when a dish sells out mid-service — one tap from the list view.
     */
    public function toggleAvailability(MenuItem $menuItem)
    {
        $menuItem->update(['is_available' => !$menuItem->is_available]);

        Cache::forget("menu-items:{$menuItem->date->toDateString()}");

        $message = $menuItem->is_available
            ? "✓ \"{$menuItem->name}\" is back on the menu."
            : "\"{$menuItem->name}\" marked as sold out.";

        return redirect()
            ->route('admin.menu-items.index', ['date' => $menuItem->date->toDateString()])
            ->with('success', $message);
    }

    /**
     * Delete a menu item permanently.
     */
    public function destroy(MenuItem $menuItem)
    {
        $date = $menuItem->date->toDateString();
        $name = $menuItem->name;
        $menuItem->delete();

        return redirect()
            ->route('admin.menu-items.index', ['date' => $date])
            ->with('success', "Removed \"{$name}\".");
    }

    /**
     * Copy all menu items from a previous date to today.
     * Useful when the owner runs the same menu items as last Friday, etc.
     */
    public function copyFromDate(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:today',
        ]);

        $source = MenuItem::forDate($request->from_date)->get();

        if ($source->isEmpty()) {
            return back()->with('error', 'No menu items found for that date.');
        }

        $copiedCount = 0;
        foreach ($source as $menuItem) {
            $exists = MenuItem::where('date', $request->to_date)
                ->where('name', $menuItem->name)
                ->where('meal_period', $menuItem->meal_period)
                ->exists();

            if (!$exists) {
                MenuItem::create([
                    'date'         => $request->to_date,
                    'meal_period'  => $menuItem->meal_period,
                    'name'         => $menuItem->name,
                    'description'  => $menuItem->description,
                    'price'        => $menuItem->price,
                    'is_available' => true,
                    'sort_order'   => $menuItem->sort_order,
                ]);
                $copiedCount++;
            }
        }

        if ($copiedCount === 0) {
            return redirect()
                ->route('admin.menu-items.index', ['date' => $request->to_date])
                ->with('warning', 'Menu items already added for this date.');
        }

        return redirect()
            ->route('admin.menu-items.index', ['date' => $request->to_date])
            ->with('success', "✓ Copied {$copiedCount} menu items.");
    }
}
