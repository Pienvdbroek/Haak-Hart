<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'type',
        'description',
        'category',
        'image',
        'images',
        'quantity_total',
        'quantity_available',
        'status',
        'video_link',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
