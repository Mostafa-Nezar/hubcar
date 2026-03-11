<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'كيف يمكنني حجز سيارة؟',
                'answer' => 'يمكنك حجز السيارة مباشرة عبر الموقع من خلال صفحة كل سيارة بالضغط على زر حجز كاش أو طلب تمويل.',
                'sort_order' => 1,
            ],
            [
                'question' => 'ما هي شروط طلب التمويل؟',
                'answer' => 'تختلف الشروط حسب جهة التمويل، ولكن بشكل عام تتطلب خطاب تعريف بالراتب، كشف حساب بنكي لآخر 3 أشهر، وهوية سارية.',
                'sort_order' => 2,
            ],
            [
                'question' => 'هل توفرون ضمان على السيارات؟',
                'answer' => 'نعم، جميع السيارات الجديدة مشمولة بضمان الوكيل، والسيارات المستعملة تخضع لفحص شامل ومعايير جودة عالية.',
                'sort_order' => 3,
            ],
            [
                'question' => 'هل يمكنني استبدال سيارتي القديمة؟',
                'answer' => 'نعم، نوفر خدمة التقييم والاستبدال لسيارتك القديمة بأفضل سعر في السوق.',
                'sort_order' => 4,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
