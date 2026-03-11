<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutPage::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'تاريخ حافل بالثقة والتميز',
                'subtitle' => 'قصتنا في RENAX',
                'description_1' => 'بدأ معرض RENAX رحلته في عالم السيارات برؤية واضحة تهدف إلى تغيير تجربة شراء السيارات في المملكة. نحن لا نبيع مجرد وسائل نقل، بل نقدم لك شريكاً لمستقبلك.',
                'description_2' => 'نفتخر بتقديم خدمة عملاء استثنائية من خلال فريق متخصص يساعدك في اختيار السيارة الأنسب لميزانيتك واحتياجاتك، مع توفير أفضل حلول التمويل من كبرى البنوك السعودية.',
                'exp_label' => 'عاماً من الخبرة',
                'exp_value' => '15+',
                'clients_label' => 'عميل سعيد',
                'clients_value' => '5000+',
                'image' => 'img/slider/1.jpg',
                'feature_1' => 'أفضل الأسعار التنافسية في السوق',
                'feature_2' => 'فحص شامل ومعايير جودة صارمة',
                'feature_3' => 'خيارات تمويل متعددة وميسرة',
            ]
        );
    }
}
