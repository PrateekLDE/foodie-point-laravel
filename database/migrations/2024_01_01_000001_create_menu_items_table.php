<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('The date this menu item is served');
            $table->enum('meal_period', ['breakfast', 'lunch', 'dinner', 'all_day'])
                  ->default('all_day');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Customers hit this query on every QR scan — keep it fast
            $table->index(['date', 'meal_period', 'is_available']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
