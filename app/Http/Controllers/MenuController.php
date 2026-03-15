<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

/**
 * MenuController — the customer-facing side.
 */
class MenuController extends Controller
{
    public function today()
    {
        $today = Carbon::today()->toDateString();

        // Cache keyed by date so it auto-invalidates at midnight
        $menuItems = Cache::remember("menu-items:{$today}", 60, function () {
            return MenuItem::forToday()
                ->get()
                ->groupBy('meal_period');
        });

        $restaurantName = config('restaurant.name', "Foodie Point");

        return view('public.menu', [
            'menuItems'      => $menuItems,
            'date'           => Carbon::today(),
            'restaurantName' => $restaurantName,
            'mealPeriods'    => MenuItem::MEAL_PERIODS,
            'isEmpty'        => $menuItems->isEmpty(),
        ]);
    }
}
