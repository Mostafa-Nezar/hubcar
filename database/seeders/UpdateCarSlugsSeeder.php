<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateCarSlugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = \App\Models\Car::all();
        
        foreach ($cars as $car) {
            if (empty($car->slug)) {
                $car->slug = \App\Helpers\ArabicSlugHelper::unique($car->name, \App\Models\Car::class, 'slug', $car->id);
                $car->save();
            }
        }
    }
}
