<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\CarImage;
use App\Models\FinanceEntity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@car.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        // Brands with real public logo URLs for better aesthetics
        $toyota = Brand::updateOrCreate(['name' => 'تويوتا'], ['logo' => 'https://www.toyota.com.sa/Assets/Saudi/Media/Logos/toyota-logo.png']);
        $hyundai = Brand::updateOrCreate(['name' => 'هيونداي'], ['logo' => 'https://www.hyundai.com/content/dam/hyundai/ww/en/images/common/hyundai-logo-black.png']);
        $ford = Brand::updateOrCreate(['name' => 'فورد'], ['logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Ford_logo_flat.svg/1200px-Ford_logo_flat.svg.png']);
        $mercedes = Brand::updateOrCreate(['name' => 'مرسيدس بنز'], ['logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/90/Mercedes-Benz_logo%2C_2011.svg/1200px-Mercedes-Benz_logo%2C_2011.svg.png']);
        $rangeRover = Brand::updateOrCreate(['name' => 'رينج روفر'], ['logo' => 'https://upload.wikimedia.org/wikipedia/en/thumb/4/4a/Land_Rover_logo.svg/1200px-Land_Rover_logo.svg.png']);

        // Finance Entities with real public logo URLs
        FinanceEntity::updateOrCreate(
            ['name' => 'مصرف الراجحي'],
            [
                'logo' => 'https://www.alrajhibank.com.sa/-/media/Project/Alrajhi-Bank/Logo/alrajhi-logo-en.png',
                'description' => 'حلول تمويلية ميسرة ومتوافقة مع الشريعة الإسلامية.'
            ]
        );
        FinanceEntity::updateOrCreate(
            ['name' => 'البنك الأهلي SNB'],
            [
                'logo' => 'https://www.alahli.com/Assets/images/logo_en.png',
                'description' => 'خيارات تمويل متنوعة لتملك سيارتك المفضلة بأسرع وقت.'
            ]
        );
        FinanceEntity::updateOrCreate(
            ['name' => 'بنك البلاد'],
            [
                'logo' => 'https://www.bankalbilad.com/Resources/images/logo.png',
                'description' => 'تمويل سيارات مرن يناسب ميزانيتك وخططك المستقبلية.'
            ]
        );

        // Car Models
        $camry_model = CarModel::updateOrCreate(['brand_id' => $toyota->id, 'name' => 'كامري']);
        $corolla_model = CarModel::updateOrCreate(['brand_id' => $toyota->id, 'name' => 'كورولا']);
        $tucson_model = CarModel::updateOrCreate(['brand_id' => $hyundai->id, 'name' => 'توسان']);
        $accent_model = CarModel::updateOrCreate(['brand_id' => $hyundai->id, 'name' => 'أكسنت']);
        $f150_model = CarModel::updateOrCreate(['brand_id' => $ford->id, 'name' => 'F-150']);
        $sClass_model = CarModel::updateOrCreate(['brand_id' => $mercedes->id, 'name' => 'S-Class']);
        $modelX_model = CarModel::updateOrCreate(['brand_id' => $hyundai->id, 'name' => 'Model X']);

        // Car Categories
        $gle = \App\Models\CarCategory::updateOrCreate(['car_model_id' => $camry_model->id, 'name' => 'GLE']);
        $se = \App\Models\CarCategory::updateOrCreate(['car_model_id' => $camry_model->id, 'name' => 'SE']);
        $smart = \App\Models\CarCategory::updateOrCreate(['car_model_id' => $tucson_model->id, 'name' => 'Smart']);
        $comfort = \App\Models\CarCategory::updateOrCreate(['car_model_id' => $tucson_model->id, 'name' => 'Comfort']);
        $lariat = \App\Models\CarCategory::updateOrCreate(['car_model_id' => $f150_model->id, 'name' => 'Lariat']);
        $s500 = \App\Models\CarCategory::updateOrCreate(['car_model_id' => $sClass_model->id, 'name' => 'S500']);

        // Cars
        $camry = Car::updateOrCreate(
            ['name' => 'تويوتا كامري 2024 GLE'],
            [
                'brand_id' => $toyota->id,
                'type' => $camry_model->name,
                'category' => $gle->name,
                'model_year' => 2024,
                'price' => 115000,
                'condition' => 'new',
                'availability_status' => 'available',
                'main_image' => 'img/cars/toyota_camry.png',
                'seats' => 5,
                'transmission' => 'Automatic',
                'fuel_type' => 'Gasoline',
                'description' => 'تويوتا كامري 2024 الجديدة كلياً، تجمع بين الأناقة والعملية والأداء القوي.',
                'specs' => [
                    'المحرك' => '2.5 لتر 4 سلندر',
                    'ناقل الحركة' => '8 سرعات أوتوماتيك',
                    'استهلاك الوقود' => '18.3 كم/لتر',
                    'المقاعد' => 'جلد فاخر'
                ],
                'is_featured' => true
            ]
        );

        $tucson = Car::updateOrCreate(
            ['name' => 'هيونداي توسان 2024 Smart'],
            [
                'brand_id' => $hyundai->id,
                'type' => $tucson_model->name,
                'category' => $smart->name,
                'model_year' => 2024,
                'price' => 105000,
                'condition' => 'new',
                'availability_status' => 'available',
                'main_image' => 'img/cars/hyundai_tucson.png',
                'seats' => 5,
                'transmission' => 'Automatic',
                'fuel_type' => 'Gasoline',
                'description' => 'توسان 2024 تقدم تجربة قيادة فريدة مع تقنيات سلامة متطورة وتصميم عصري.',
                'specs' => [
                    'المحرك' => '2.0 لتر',
                    'الدفع' => 'أمامي',
                    'الشاشة' => '8 بوصة تعمل باللمس',
                    'الحساسات' => 'خلفية وأمامية'
                ],
                'is_featured' => true
            ]
        );

        $f150 = Car::updateOrCreate(
            ['name' => 'فورد F-150 2024 Lariat'],
            [
                'brand_id' => $ford->id,
                'type' => $f150_model->name,
                'category' => $lariat->name,
                'model_year' => 2024,
                'price' => 245000,
                'condition' => 'new',
                'availability_status' => 'available',
                'main_image' => 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?q=80&w=1000&auto=format&fit=crop',
                'seats' => 5,
                'transmission' => 'Automatic',
                'fuel_type' => 'Gasoline',
                'description' => 'القوة والمتانة تجتمع في فورد F-150 الجديدة، شريكك في جميع الطرقات.',
                'is_featured' => true
            ]
        );

        $sClass = Car::updateOrCreate(
            ['name' => 'مرسيدس S-Class 2024 S500'],
            [
                'brand_id' => $mercedes->id,
                'type' => $sClass_model->name,
                'category' => $s500->name,
                'model_year' => 2024,
                'price' => 750000,
                'condition' => 'new',
                'availability_status' => 'available',
                'main_image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                'seats' => 5,
                'transmission' => 'Automatic',
                'fuel_type' => 'Hybrid',
                'description' => 'ذروة الرفاهية والفخامة الألمانية، مرسيدس S-Class تضع معايير جديدة للسيارات الفاخرة.',
                'is_featured' => true
            ]
        );

        $model_X = Car::updateOrCreate(
            ['name' => 'تسلا موديل X 2024'],
            [
                'brand_id' => $hyundai->id,
                'type' => $modelX_model->name,
                'category' => 'Futuristic',
                'model_year' => 2024,
                'price' => 450000,
                'condition' => 'new',
                'availability_status' => 'available',
                'main_image' => 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?q=80&w=1000&auto=format&fit=crop',
                'seats' => 7,
                'transmission' => 'None',
                'fuel_type' => 'Electric',
                'description' => 'أسرع سيارة SUV كهربائية في العالم مع أبواب جناح الصقر المذهلة.',
                'is_featured' => true
            ]
        );

        // Gallery Images Enhancement
        CarImage::updateOrCreate(['car_id' => $camry->id, 'path' => 'img/cars/toyota_camry.png', 'sort_order' => 1]);
        CarImage::updateOrCreate(['car_id' => $camry->id, 'path' => 'https://images.unsplash.com/photo-1619767886558-efdc259cde1a?q=80&w=800', 'sort_order' => 2]);
        CarImage::updateOrCreate(['car_id' => $camry->id, 'path' => 'https://images.unsplash.com/photo-1621259182978-fbf93132d53d?q=80&w=800', 'sort_order' => 3]);
        
        CarImage::updateOrCreate(['car_id' => $tucson->id, 'path' => 'img/cars/hyundai_tucson.png', 'sort_order' => 1]);
        CarImage::updateOrCreate(['car_id' => $tucson->id, 'path' => 'https://images.unsplash.com/photo-1621259182978-fbf93132d53d?q=80&w=800', 'sort_order' => 2]);

        $this->call([
            FaqSeeder::class,
            AboutPageSeeder::class,
            SettingSeeder::class,
            ContactMessageSeeder::class,
            TermSeeder::class,
            PrivacySeeder::class,
            UpdateCarSlugsSeeder::class
        ]);
    }
}
