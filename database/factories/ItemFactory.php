<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        $categories = ['Camera', 'Audio', 'Accu', 'Rugzak', 'Kits', 'Overig'];
        $total = $this->faker->numberBetween(1, 20);
        $available = $this->faker->numberBetween(0, $total);

        return [
            'item_name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'category' => $this->faker->randomElement($categories),
            'image' => null, // of vul met een placeholder: 'items/placeholder.jpg'
            'quantity_total' => $total,
            'quantity_available' => $available,
            'status' => $available > 0 ? 'available' : 'unavailable',
            'video_link' => $this->faker->optional()->url(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
