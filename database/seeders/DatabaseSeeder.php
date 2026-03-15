<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application.
     *
          */
    public function run(): void
    {
        // ── Owner account ─────────────────────────────────────────────────────
        // Credentials come from .env. The nephew sets these once at install time.
        DB::table('users')->insert([
            'name'       => env('OWNER_NAME', 'Restaurant Owner'),
            'email'      => env('OWNER_EMAIL', 'admin@example.com'),
            'password'   => Hash::make(env('OWNER_PASSWORD', 'admin123')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ── Restaurant settings ───────────────────────────────────────────────
        DB::table('settings')->insert([
            ['key' => 'restaurant_name', 'value' => env('RESTAURANT_NAME', "Foodie Point"), 'created_at' => now(), 'updated_at' => now()],
        ]);

        $today = Carbon::today()->toDateString();

        $demos = [
            ['meal_period' => 'lunch',  'name' => 'Sandwich',      'description' => 'Sandwich',    'price' => 9.00,  'sort_order' => 0],
            ['meal_period' => 'lunch',  'name' => 'Chole bhature',   'description' => 'Chole bhature',                'price' => 13.50, 'sort_order' => 1],
            ['meal_period' => 'dinner', 'name' => 'Biryani',      'description' => 'Biryani',   'price' => 24.00, 'sort_order' => 0],
            ['meal_period' => 'dinner', 'name' => 'Noodles',      'description' => 'Noodles',    'price' => 28.00, 'sort_order' => 1],
            ['meal_period' => 'dinner', 'name' => 'Paneer Curry',       'description' => 'Paneer Curry',        'price' => 18.00, 'sort_order' => 2],
            ['meal_period' => 'all_day','name' => 'Butterscotch ice cream','description' => 'Butterscotch ice cream',             'price' => 8.00,  'sort_order' => 0],
        ];

        foreach ($demos as $demo) {
            MenuItem::create(array_merge($demo, [
                'date'         => $today,
                'is_available' => true,
            ]));
        }
    }
}
