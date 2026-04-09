<?php

namespace App\Filament\Admin\Resources\SeoPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SeoPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('رابط الصفحة')
                    ->description('أدخل المسار الخاص بالصفحة (مثلاً /about أو /banks)')
                    ->schema([
                        Select::make('url_path')
                            ->label('المسار (URL Path)')
                            ->options([
                                '/' => 'الصفحة الرئيسية',
                                '/about' => 'من نحن',
                                '/banks' => 'جهات التمويل',
                                '/faq' => 'الأسئلة الشائعة',
                                '/terms' => 'الشروط والأحكام',
                                '/privacy' => 'سياسة الخصوصية',
                                '/contact' => 'اتصل بنا',
                                '/cars' => 'معرض السيارات',
                                '/quick-booking' => 'طلب حجز سريع',
                            ])
                            ->searchable()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                $options = [
                                    '/' => 'الصفحة الرئيسية',
                                    '/about' => 'من نحن',
                                    '/banks' => 'جهات التمويل',
                                    '/faq' => 'الأسئلة الشائعة',
                                    '/terms' => 'الشروط والأحكام',
                                    '/privacy' => 'سياسة الخصوصية',
                                    '/contact' => 'اتصل بنا',
                                    '/cars' => 'معرض السيارات',
                                    '/quick-booking' => 'طلب حجز سريع',
                                ];
                                $set('page_name', $options[$state] ?? $state);
                            }),
                        TextInput::make('page_name')
                            ->label('اسم الصفحة (للتنظيم الداخلي)')
                            ->required()
                            ->readOnly()
                            ->placeholder('سيتم ملؤه تلقائياً'),
                    ])->columns(2),

                Section::make('بيانات الـ Meta')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('عنوان المتصفح (Title Tag)')
                            ->placeholder('أدخل العنوان الذي سيظهر في أعلى المتصفح (Tab)'),
                        Textarea::make('meta_description')
                            ->label('وصف الميتا (Meta Description)')
                            ->rows(3),
                        TagsInput::make('meta_keywords')
                            ->label('الكلمات المفتاحية (Keywords)'),
                        Select::make('seo_robots')
                            ->label('إعدادات الروبوت (Robots)')
                            ->options([
                                'index, follow' => 'Index, Follow (افتراضي)',
                                'noindex, follow' => 'NoIndex, Follow',
                                'index, nofollow' => 'Index, NoFollow',
                                'noindex, nofollow' => 'NoIndex, NoFollow',
                            ])
                            ->default('index, follow'),
                    ]),

                Section::make('وسائل التواصل الاجتماعي (Open Graph)')
                    ->collapsible()
                    ->schema([
                        TextInput::make('og_title')
                            ->label('عنوان OG (Facebook Title)')
                            ->placeholder('العنوان عند المشاركة على فيسبوك'),
                        Textarea::make('og_description')
                            ->label('وصف OG (Facebook Description)')
                            ->rows(2),
                        Select::make('og_type')
                            ->label('نوع OG (Type)')
                            ->options([
                                'website' => 'Website',
                                'article' => 'Article',
                                'product' => 'Product',
                            ])
                            ->default('website'),
                        FileUpload::make('og_image')
                            ->label('صورة الـ Facebook (OG Image)')
                            ->image()
                            ->directory('seo'),
                    ]),

                Section::make('وسائل التواصل الاجتماعي (Twitter)')
                    ->collapsible()
                    ->schema([
                        TextInput::make('twitter_title')
                            ->label('عنوان Twitter')
                            ->placeholder('العنوان عند المشاركة على تويتر'),
                        Textarea::make('twitter_description')
                            ->label('وصف Twitter')
                            ->rows(2),
                        Select::make('twitter_card')
                            ->label('نوع بطاقة تويتر (Twitter Card)')
                            ->options([
                                'summary' => 'Summary',
                                'summary_large_image' => 'Summary Large Image',
                                'app' => 'App',
                            ])
                            ->default('summary_large_image'),
                        FileUpload::make('twitter_image')
                            ->label('صورة الـ Twitter')
                            ->image()
                            ->directory('seo'),
                    ])->columns(2),
            ]);
    }
}
