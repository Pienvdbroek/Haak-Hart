<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'item_id',
        'borrow_date',
        'end_date',
        'quantity',
        'commentary',
        'late'
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'end_date' => 'date',
        'late' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
