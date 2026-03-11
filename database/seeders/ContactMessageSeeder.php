<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactMessage::create([
            'name' => 'محمد علي',
            'email' => 'mohamed@example.com',
            'subject' => 'استفسار عن تمويل كامري',
            'message' => 'أود الاستفسار عن تفاصيل تمويل سيارة تويوتا كامري 2024 والمستندات المطلوبة.',
            'status' => 'New',
        ]);

        ContactMessage::create([
            'name' => 'أحمد خالد',
            'email' => 'ahmed@example.com',
            'subject' => 'صيانة سيارات',
            'message' => 'هل يتوفر لديكم قسم خاص للصيانة بعد البيع؟',
            'status' => 'Read',
        ]);
    }
}
