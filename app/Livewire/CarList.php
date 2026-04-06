<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Car;
use Livewire\Component;
use Livewire\WithPagination;

class CarList extends Component
{
    use WithPagination;

    private const FILTERS_SESSION_KEY = 'cars_list.filters';

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
        $this->updateDependentLists();

        // Support legacy/query links like ?brand=ID
        $this->brand_id = request('brand', $this->brand_id);

        $hasQueryFilters = request()->hasAny([
            'brand',
            'brand_id',
            'type',
            'category',
            'year',
            'sort',
            'search',
            'viewMode',
            'page',
        ]);

        if (!$hasQueryFilters) {
            $saved = session(self::FILTERS_SESSION_KEY, []);

            $this->brand_id = $saved['brand_id'] ?? $this->brand_id;
            $this->type = $saved['type'] ?? $this->type;
            $this->category = $saved['category'] ?? $this->category;
            $this->year = $saved['year'] ?? $this->year;
            $this->sort = $saved['sort'] ?? $this->sort;
            $this->search = $saved['search'] ?? $this->search;
            $this->viewMode = $saved['viewMode'] ?? $this->viewMode;

            if (!empty($saved['page']) && (int) $saved['page'] > 1) {
                $this->setPage((int) $saved['page']);
            }
        }
    }

    public function updating($name)
    {
        $this->resetPage();
    }

    public function updatedBrandId()
    {
        $this->type = '';
        $this->category = '';
        $this->year = '';
        $this->updateDependentLists();
    }

    public function updatedType()
    {
        $this->category = '';
        $this->year = '';
        $this->updateDependentLists();
    }

    public function updatedCategory()
    {
        $this->year = '';
        $this->updateDependentLists();
    }

    private function updateDependentLists()
    {
        $this->types_list = $this->brand_id 
            ? Car::where('brand_id', $this->brand_id)->distinct()->pluck('type')->filter()->values()
            : collect();

        $this->categories_list = ($this->brand_id && $this->type)
            ? Car::where('brand_id', $this->brand_id)->where('type', $this->type)->distinct()->pluck('category')->filter()->values()
            : collect();

        $this->years_list = ($this->brand_id && $this->type && $this->category)
            ? Car::where('brand_id', $this->brand_id)->where('type', $this->type)->where('category', $this->category)->distinct()->orderBy('model_year', 'desc')->pluck('model_year')->filter()->values()
            : collect();
    }

    public function resetFilters()
    {
        $this->reset(['brand_id', 'type', 'category', 'year', 'search', 'sort']);
        $this->viewMode = 'grid';
        session()->forget(self::FILTERS_SESSION_KEY);
    }

    private function persistFilters(int $page): void
    {
        session([
            self::FILTERS_SESSION_KEY => [
                'brand_id' => $this->brand_id,
                'type' => $this->type,
                'category' => $this->category,
                'year' => $this->year,
                'sort' => $this->sort,
                'search' => $this->search,
                'viewMode' => $this->viewMode,
                'page' => $page,
            ],
        ]);
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
            $query->where(function ($q) {
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

        $cars = $query->paginate(12)->withQueryString();
        $this->persistFilters($cars->currentPage());

        return view('livewire.car-list', [
            'cars' => $cars
        ]);
    }
}
