<?php

namespace Database\Seeders;

use App\Models\Privacy;
use Illuminate\Database\Seeder;

class PrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $privacies = [
            [
                'title' => 'جمع المعلومات',
                'content' => "نقوم بجمع المعلومات اللازمة فقط لتقديم خدماتنا إليكم، وتتضمن:\n1. المعلومات التي تقدمونها عند طلب حجز أو تمويل (الاسم، الجوال، البريد).\n2. معلومات عن تصفحك للموقع لتحسين تجربة المستخدم.\n3. لا نقوم بجمع أي معلومات حساسة دون موافقة صريحة.",
                'sort_order' => 1,
            ],
            [
                'title' => 'استخدام المعلومات',
                'content' => "تستخدم المعلومات التي نجمعها في:\n1. التواصل معكم بخصوص طلباتكم.\n2. إرسال العروض والتحديثات الجديدة (بناءً على اشتراككم).\n3. تحليل أداء الموقع وتقديم تجربة مخصصة.",
                'sort_order' => 2,
            ],
            [
                'title' => 'حماية البيانات',
                'content' => "نحن نلتزم بأقصى معايير الحماية لضمان سرية معلوماتكم. لا نقوم ببيع أو مشاركة بياناتكم مع أي جهات خارجية إلا الجهات التمويلية التي تطلبونها رسمياً لإتمام عملية التمويل.",
                'sort_order' => 3,
            ],
        ];

        foreach ($privacies as $privacy) {
            Privacy::updateOrCreate(['title' => $privacy['title']], $privacy);
        }
    }
}
