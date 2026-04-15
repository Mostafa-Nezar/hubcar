<?php

namespace App\Livewire;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CarFavoriteButton extends Component
{
    public $carId;
    public $isFavorite = false;
    public $style = 'default'; // 'default' for cards, 'large' for details

    public function mount($carId, $style = 'default')
    {
        $this->carId = $carId;
        $this->style = $style;
        $this->checkIfFavorite();
    }

    public function checkIfFavorite()
    {
        if (Auth::guard('customer')->check()) {
            $this->isFavorite = Wishlist::where('customer_id', Auth::guard('customer')->id())
                ->where('car_id', $this->carId)
                ->exists();
        } else {
            $this->isFavorite = false;
        }
    }

    public function toggleFavorite()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('login');
        }

        $customerId = Auth::guard('customer')->id();
        
        $wishlist = Wishlist::where('customer_id', $customerId)
            ->where('car_id', $this->carId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $this->isFavorite = false;
        } else {
            Wishlist::create([
                'customer_id' => $customerId,
                'car_id' => $this->carId,
            ]);
            $this->isFavorite = true;
        }
    }

    public function render()
    {
        return view('livewire.car-favorite-button');
    }
}
