namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Menu;

class BookingForm extends Component
{
    public $nama_pelanggan, $email, $nomor_telepon;
    public $jumlah_tamu, $hari, $waktu;
    public $menu_id;
    public $success;

    protected $rules = [
        'nama_pelanggan' => 'required|string|max:100',
        'email' => 'required|email',
        'nomor_telepon' => 'required',
        'jumlah_tamu' => 'required|integer',
        'hari' => 'required|date',
        'waktu' => 'required',
        'menu_id' => 'required|exists:menus,id'
    ];

    public function submit()
    {
        $this->validate();

        Booking::create([
            'nama_pelanggan' => $this->nama_pelanggan,
            'email' => $this->email,
            'nomor_telepon' => $this->nomor_telepon,
            'jumlah_tamu' => $this->jumlah_tamu,
            'hari' => $this->hari,
            'waktu' => $this->waktu,
            'menu_id' => $this->menu_id
        ]);

        $this->reset();
        $this->success = 'Booking berhasil dikirim!';
    }

    public function render()
    {
        return view('livewire.booking-form', [
            'menus' => Menu::all()
        ]);
    }
}
