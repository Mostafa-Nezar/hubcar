<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file including public pages and cars.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $sitemap .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";

        // Add home page
        $sitemap .= "  <url>\n";
        $sitemap .= "    <loc>" . route('home') . "</loc>\n";
        $sitemap .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
        $sitemap .= "    <changefreq>daily</changefreq>\n";
        $sitemap .= "    <priority>1.0</priority>\n";
        $sitemap .= "  </url>\n";

        // Add cars
        $cars = Car::all();
        foreach ($cars as $car) {
            $sitemap .= "  <url>\n";
            $sitemap .= "    <loc>" . route('cars.show', $car->slug) . "</loc>\n";
            $sitemap .= "    <lastmod>" . ($car->updated_at ? $car->updated_at->format('Y-m-d') : date('Y-m-d')) . "</lastmod>\n";
            $sitemap .= "    <changefreq>weekly</changefreq>\n";
            $sitemap .= "    <priority>0.8</priority>\n";
            $sitemap .= "  </url>\n";
        }

        // Add other public pages
        $pages = [
            'cars.index' => 0.9,
            'about' => 0.7,
            'banks' => 0.7,
            'faq' => 0.6,
            'terms' => 0.5,
            'privacy' => 0.5,
            'contact' => 0.7,
        ];

        foreach ($pages as $route => $priority) {
            $sitemap .= "  <url>\n";
            $sitemap .= "    <loc>" . route($route) . "</loc>\n";
            $sitemap .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $sitemap .= "    <changefreq>monthly</changefreq>\n";
            $sitemap .= "    <priority>" . $priority . "</priority>\n";
            $sitemap .= "  </url>\n";
        }

        $sitemap .= "</urlset>\n";

        File::put(public_path('sitemap.xml'), $sitemap);

        $this->info('Sitemap generated successfully!');
    }
}
