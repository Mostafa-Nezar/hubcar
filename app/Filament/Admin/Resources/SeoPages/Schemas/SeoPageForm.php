<?php

namespace App\Filament\Admin\Resources\SeoPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
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
                        TextInput::make('url_path')
                            ->label('المسار (URL Path)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('/example-page'),
                        TextInput::make('page_name')
                            ->label('اسم الصفحة (للتنظيم الداخلي)')
                            ->required()
                            ->placeholder('صفحة من نحن، جهات التمويل، إلخ'),
                    ])->columns(2),

                Section::make('بيانات الـ Meta')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('عنوان الميتا (Meta Title)')
                            ->placeholder('أدخل عنوان الصفحة لمحركات البحث'),
                        Textarea::make('meta_description')
                            ->label('وصف الميتا (Meta Description)')
                            ->rows(3),
                        TagsInput::make('meta_keywords')
                            ->label('الكلمات المفتاحية (Keywords)'),
                    ]),

                Section::make('وسائل التواصل الاجتماعي (Open Graph / Twitter)')
                    ->schema([
                        FileUpload::make('og_image')
                            ->label('صورة الـ Facebook (OG Image)')
                            ->image()
                            ->directory('seo'),
                        FileUpload::make('twitter_image')
                            ->label('صورة الـ Twitter')
                            ->image()
                            ->directory('seo'),
                    ])->columns(2),
            ]);
    }
}
