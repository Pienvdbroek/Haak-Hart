<?php

namespace Database\Seeders;

use App\Models\Borrowing;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    public function run(): void
    {
        Borrowing::query()->delete();

        $user = User::where('email', 'user@example.com')->first();

        if (!$user) {
            return;
        }

        $reservations = [
            [
                'item_name' => 'Wireless ME',
                'quantity' => 1,
                'borrow_date' => now()->addDays(1),
                'end_date' => now()->addDays(7),
                'commentary' => 'Voor interview project.',
            ],
            [
                'item_name' => 'Sony set ZV-E10',
                'quantity' => 1,
                'borrow_date' => now()->addDays(2),
                'end_date' => now()->addDays(10),
                'commentary' => 'Voor video-opname.',
            ],
        ];

        foreach ($reservations as $reservation) {
            $item = Item::where('item_name', $reservation['item_name'])->first();

            if (!$item || $item->quantity_available < $reservation['quantity']) {
                continue;
            }

            Borrowing::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'borrow_date' => $reservation['borrow_date'],
                'end_date' => $reservation['end_date'],
                'quantity' => $reservation['quantity'],
                'commentary' => $reservation['commentary'],
                'late' => false,
            ]);

            $item->decrement('quantity_available', $reservation['quantity']);
        }
    }
}
