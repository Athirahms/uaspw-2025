<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'kategori',
        'gambar',
    ];
    
    public function bookings() {
        return $this->belongsToMany(Booking::class, 'booking_menu')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
        
}
