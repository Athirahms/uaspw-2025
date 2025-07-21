<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookkingMenu extends Model
{
    use HasFactory;

    protected $table = 'bookking_menu';

    protected $fillable = [
        'booking_id',
        'menu_id',
        'quantity',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
