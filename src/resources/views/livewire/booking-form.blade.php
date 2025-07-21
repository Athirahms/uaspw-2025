<div>
    <div class="form-header">
        <h3>Book A Table</h3>
        <p>Please fill the form below to make a reservation</p>
    </div>

    @if ($success)
        <div class="alert alert-success">{{ $success }}</div>
    @endif

    <form wire:submit.prevent="submit" class="php-email-form mt-4">
        <div class="row gy-4">
            <div class="col-lg-4 form-group">
                <input type="text" wire:model="nama_pelanggan" class="form-control" placeholder="Your Name">
                @error('nama_pelanggan') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-lg-4 form-group">
                <input type="email" wire:model="email" class="form-control" placeholder="Your Email">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-lg-4 form-group">
                <input type="text" wire:model="nomor_telepon" class="form-control" placeholder="Your Phone">
                @error('nomor_telepon') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-lg-4 form-group">
                <select wire:model="jumlah_tamu" class="form-select">
                    <option value="">Number of guests</option>
                    @for ($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Person' : 'People' }}</option>
                    @endfor
                </select>
                @error('jumlah_tamu') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-lg-4 form-group">
                <input type="date" wire:model="hari" class="form-control">
                @error('hari') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-lg-4 form-group">
                <input type="time" wire:model="waktu" class="form-control">
                @error('waktu') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-lg-12 form-group">
                <select wire:model="menu_id" class="form-select">
                    <option value="">Select Menu</option>
                    @foreach ($menus as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->nama_menu }}</option>
                    @endforeach
                </select>
                @error('menu_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn-book-table">Book Now</button>
        </div>
    </form>
</div>
