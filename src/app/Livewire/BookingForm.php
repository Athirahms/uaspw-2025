<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Menu;
use Livewire\Component;

class BookingForm extends Component
{
    public $nama_pelanggan;
    public $email;
    public $nomor_telepon;
    public $jumlah_tamu;
    public $hari;
    public $waktu;
    public $menu_id;

    public $menus = [];
    public $success;

    public function mount()
    {
        $this->menus = Menu::all();
    }

    public function submit()
    {
        $validated = $this->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|email',
            'nomor_telepon' => 'required|string|max:20',
            'jumlah_tamu' => 'required|integer|min:1',
            'hari' => 'required|date',
            'waktu' => 'required',
            'menu_id' => 'required|exists:menus,id',
        ]);

        Booking::create($validated);

        $this->reset([
            'nama_pelanggan', 'email', 'nomor_telepon', 'jumlah_tamu', 'hari', 'waktu', 'menu_id'
        ]);

        $this->success = 'Thank you! Your table has been booked.';
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
