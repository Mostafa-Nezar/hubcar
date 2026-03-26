<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Banner as BannerModel;

class Banner extends Component
{
    public $banner;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->banner = BannerModel::where('is_active', true)->latest()->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.banner');
    }
}
