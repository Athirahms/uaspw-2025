<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'email',
        'nomor_telepon',
        'jumlah_tamu',
        'hari',
        'waktu',
        'menu_id',
    ];

    public function menus() {
        return $this->belongsToMany(Menu::class, 'booking_menu')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    
}
