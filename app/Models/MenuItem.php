<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    protected $fillable = [
        'date',
        'meal_period',
        'name',
        'description',
        'price',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'date'         => 'date',
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
        'sort_order'   => 'integer',
    ];

    public const MEAL_PERIODS = [
        'breakfast' => 'Breakfast',
        'lunch'     => 'Lunch',
        'dinner'    => 'Dinner',
        'all_day'   => 'All Day',
    ];

    // laravel accessor to format price for display, when fetched prce is a decimal, but we want to show it as a string with $ and 2 decimals
    public function getFormattedPriceAttribute(): string
    {
        return $this->price !== null
            ? '$' . number_format($this->price, 2)
            : '--';
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    /**
     * Scope to today's available menu items — the most common query in the system.
     */
    public function scopeForToday(Builder $query): Builder
    {
        return $query
            ->where('date', Carbon::today())
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->orderBy('created_at');
    }

    public function scopeForDate(Builder $query, string $date): Builder
    {
        return $query
            ->where('date', $date)
            ->orderBy('meal_period')
            ->orderBy('sort_order')
            ->orderBy('created_at');
    }
}
