<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class BorrowingFactory extends Factory
{
    protected $model = Borrowing::class;

    public function definition()
    {
        // Kies willekeurige gebruiker en item
        $user = User::inRandomOrder()->first() ?? User::factory();
        $item = Item::inRandomOrder()->first() ?? Item::factory();

        // Datums: leenperiode tussen 1 en 30 dagen
        $borrowDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = (clone $borrowDate)->modify('+' . $this->faker->numberBetween(1, 14) . ' days');

        // Aantal: maximaal de beschikbare voorraad (als item bestaat, anders 1-5)
        $maxQty = $item->exists ? $item->quantity_available : 5;
        $quantity = $this->faker->numberBetween(1, max(1, $maxQty));

        // Late flag: 10% kans op te laat (als einddatum in het verleden ligt)
        $isLate = false;
        if ($endDate < now() && $this->faker->boolean(10)) {
            $isLate = true;
        }

        return [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'borrow_date' => $borrowDate,
            'end_date' => $endDate,
            'quantity' => $quantity,
            'commentary' => $this->faker->optional(0.7)->sentence(),
            'late' => $isLate,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
