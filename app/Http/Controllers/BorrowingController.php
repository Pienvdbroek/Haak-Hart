<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    // Alle reserveringen (voor admin)
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'item'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Voeg status toe
        $borrowings->transform(function ($borrowing) {
            $today = now()->startOfDay();
            $endDate = \Carbon\Carbon::parse($borrowing->end_date)->startOfDay();

            if ($borrowing->late) {
                $borrowing->status = 'Te laat';
            } elseif ($endDate < $today) {
                $borrowing->status = 'Verlopen';
            } else {
                $borrowing->status = 'Actief';
            }
            return $borrowing;
        });

        return response()->json($borrowings);
    }
    public function userReservations()
    {
        $borrowings = Borrowing::with('item')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $borrowings->transform(function ($borrowing) {
            $today = now()->startOfDay();
            $endDate = \Carbon\Carbon::parse($borrowing->end_date)->startOfDay();

            if ($borrowing->late) {
                $borrowing->status = 'Te laat';
            } elseif ($endDate < $today) {
                $borrowing->status = 'Verlopen';
            } else {
                $borrowing->status = 'Actief';
            }
            return $borrowing;
        });

        return response()->json($borrowings);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'item_id' => 'required|exists:items,id',
                'quantity' => 'required|integer|min:1',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'commentary' => 'nullable|string',
            ]);

            $item = Item::findOrFail($validated['item_id']);

            if ($item->quantity_available < $validated['quantity']) {
                return response()->json([
                    'message' => 'Niet voldoende voorraad. Nog maar ' . $item->quantity_available . ' beschikbaar.'
                ], 422);
            }

            DB::transaction(function () use ($item, $validated) {
                Borrowing::create([
                    'user_id' => Auth::id(),
                    'item_id' => $validated['item_id'],
                    'borrow_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'quantity' => $validated['quantity'],
                    'commentary' => $validated['commentary'],
                    'late' => false,
                ]);

                $item->decrement('quantity_available', $validated['quantity']);
            });

            return response()->json(['message' => 'Reservering succesvol'], 201);

        } catch (\Exception $e) {
            \Log::error('Reservering fout: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $item = $borrowing->item;

        DB::transaction(function () use ($borrowing, $item) {
            // Alleen quantity_available terugzetten
            $item->increment('quantity_available', $borrowing->quantity);
            // quantity_total blijft onveranderd
            $borrowing->delete();
        });

        return response()->json(['message' => 'Reservering verwijderd'], 200);
    }
    public function returnItem($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $item = $borrowing->item;

        // Alleen de eigen gebruiker kan zijn eigen reservering inleveren
        if ($borrowing->user_id !== Auth::id()) {
            return response()->json(['message' => 'Niet toegestaan'], 403);
        }

        DB::transaction(function () use ($borrowing, $item) {
            // Voorraad terugzetten
            $item->increment('quantity_available', $borrowing->quantity);
            // Reservering verwijderen
            $borrowing->delete();
        });

        return response()->json(['message' => 'Product succesvol ingeleverd'], 200);
    }

}
