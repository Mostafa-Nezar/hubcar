<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'RENAX',
                'logo' => null,
                'phone' => '+966 50 000 0000',
                'email' => 'info@renax.com',
                'address' => 'الرياض، طريق خريص، المملكة العربية السعودية',
                'whatsapp' => '966500000000',
                'twitter' => '#',
                'instagram' => '#',
                'snapchat' => '#',
                'facebook' => '#',
                'work_hours_weekdays' => 'السبت - الخميس: 9:00 ص - 10:00 م',
                'work_hours_friday' => 'الجمعة: 4:00 م - 10:00 م',
                'footer_description' => 'نحن معرض سيارات رائد في المملكة العربية السعودية، نقدم أفضل السيارات الجديدة والمستعملة بأفضل الأسعار وأعلى معايير الجودة.'
            ]
        );
    }
}
