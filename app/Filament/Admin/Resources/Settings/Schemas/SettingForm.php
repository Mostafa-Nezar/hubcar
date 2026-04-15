<?php

namespace App\Filament\Admin\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('الإعدادات العامة')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')
                            ->label('اسم الموقع')
                            ->required()
                            ->default('RENAX'),
                        \Filament\Forms\Components\FileUpload::make('logo')
                            ->label('الشعار (Logo)')
                            ->image()
                            ->directory('settings'),
                    ]),
                \Filament\Schemas\Components\Section::make('معلومات التواصل')
                    ->columns(2)
                    ->schema([
                        TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->regex('/^\+?[0-9\s\-]{9,20}$/')
                            ->validationMessages([
                                'regex' => 'يجب إدخال رقم هاتف صحيح يتكون من الأرقام فقط.',
                            ])
                            ->helperText('اكتب رقم الهاتف بصيغة صحيحة مثل 05XXXXXXXX')
                            ->default(null),
                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->default(null),
                        TextInput::make('address')
                            ->label('العنوان')
                            ->default(null),
                        TextInput::make('whatsapp')
                            ->label('رقم الواتساب')
                            ->tel()
                            ->regex('/^\+?[0-9\s\-]{9,20}$/')
                            ->validationMessages([
                                'regex' => 'يجب إدخال رقم صحيح يتكون من الأرقام فقط.',
                            ])
                            ->helperText('اكتب رقم واتساب صحيح')
                            ->default(null),
                    ]),
                \Filament\Schemas\Components\Section::make('ساعات العمل')
                    ->columns(2)
                    ->schema([
                        TextInput::make('work_hours_weekdays')
                            ->label('ساعات العمل (الأيام العادية)')
                            ->placeholder('السبت - الخميس: 9:00 ص - 10:00 م')
                            ->default(null),
                        TextInput::make('work_hours_friday')
                            ->label('ساعات العمل (الجمعة)')
                            ->placeholder('الجمعة: 4:00 م - 10:00 م')
                            ->default(null),
                    ]),
                \Filament\Schemas\Components\Section::make('وسائل التواصل الاجتماعي')
                    ->columns(2)
                    ->schema([
                        TextInput::make('twitter')
                            ->label('تويتر (X)')
                            // ->url()
                            ->default(null),
                        TextInput::make('instagram')
                            ->label('انستقرام')
                            // ->url()
                            ->default(null),
                        TextInput::make('snapchat')
                            ->label('سناب شات')
                            // ->url()
                            ->default(null),
                        TextInput::make('facebook')
                            ->label('فيسبوك')
                            // ->url()
                            ->default(null),
                    ]),
                \Filament\Schemas\Components\Section::make('التذييل (Footer)')
                    ->schema([
                        Textarea::make('footer_description')
                            ->label('وصف التذييل')
                            ->rows(3)
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
                \Filament\Schemas\Components\Section::make('إعدادات Google reCAPTCHA')
                    ->description('تحكم في حماية النماذج ضد الرسائل المزعجة (Spam)')
                    ->schema([
                        TextInput::make('recaptcha_site_key')
                            ->label('Site Key')
                            ->placeholder('6Lc...'),
                        TextInput::make('recaptcha_secret_key')
                            ->label('Secret Key')
                            ->password()
                            ->revealable()
                            ->placeholder('6Lc...'),
                        \Filament\Forms\Components\Toggle::make('recaptcha_enabled_contact')
                            ->label('تفعيل في صفحة "اتصل بنا"'),
                        \Filament\Forms\Components\Toggle::make('recaptcha_enabled_booking')
                            ->label('تفعيل في نموذج "طلب الحجز"'),
                    ])->columns(2),
                \Filament\Schemas\Components\Section::make('إعدادات محركات البحث (SEO)')
                    ->description('تحكم في كيفية ظهور موقعك في نتائج بحث جوجل')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('عنوان الموقع لمحركات البحث')
                            ->placeholder('أفضل معرض سيارات في السعودية - هيوب كار')
                            ->columnSpanFull(),
                        Textarea::make('meta_description')
                            ->label('وصف الموقع لمحركات البحث')
                            ->rows(3)
                            ->placeholder('معرض هيوب كار يوفر لك أفضل مجموعة من السيارات الجديدة والمستعملة...')
                            ->columnSpanFull(),
                        Textarea::make('meta_keywords')
                            ->label('الكلمات المفتاحية (Keywords)')
                            ->rows(2)
                            ->placeholder('سيارات، معرض سيارات، الرياض، شراء سيارة...')
                            ->columnSpanFull(),
                        \Filament\Forms\Components\FileUpload::make('og_image')
                            ->label('صورة المشاركة (Open Graph)')
                            ->image()
                            ->directory('seo')
                            ->columnSpanFull(),
                    ])->columns(1),
            ]);
    }
}