<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Car;
use Livewire\Component;
use Livewire\WithPagination;

class CarList extends Component
{
    use WithPagination;

    public $brand_id = '';
    public $type = '';
    public $category = '';
    public $year = '';
    public $sort = 'newest';
    public $search = '';
    public $viewMode = 'grid'; // grid or list

    public $brands_list = [];
    public $types_list = [];
    public $categories_list = [];
    public $years_list = [];

    protected $queryString = [
        'brand_id' => ['except' => ''],
        'type' => ['except' => ''],
        'category' => ['except' => ''],
        'year' => ['except' => ''],
        'sort' => ['except' => 'newest'],
        'search' => ['except' => ''],
        'viewMode' => ['except' => 'grid'],
    ];

    public function mount()
    {
        $this->brands_list = Brand::all();
        $this->types_list = Car::distinct()->pluck('type')->filter()->values();
        $this->categories_list = Car::distinct()->pluck('category')->filter()->values();
        $this->years_list = Car::distinct()->orderBy('model_year', 'desc')->pluck('model_year')->filter()->values();
        
        // Populate from request if needed (though queryString handles it)
        $this->brand_id = request('brand', $this->brand_id);
    }

    public function updating($name)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['brand_id', 'type', 'category', 'year', 'search', 'sort']);
    }

    public function render()
    {
        $query = Car::query();

        if ($this->brand_id) {
            $query->where('brand_id', $this->brand_id);
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        if ($this->year) {
            $query->where('model_year', $this->year);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->sort === 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sort === 'price_high') {
            $query->orderBy('price', 'desc');
        } elseif ($this->sort === 'year_newest') {
            $query->orderBy('model_year', 'desc');
        } elseif ($this->sort === 'year_oldest') {
            $query->orderBy('model_year', 'asc');
        } else {
            $query->latest();
        }

        $cars = $query->paginate(12);

        return view('livewire.car-list', [
            'cars' => $cars
        ]);
    }
}
