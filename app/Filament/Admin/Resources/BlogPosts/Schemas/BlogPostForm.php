<?php

namespace App\Filament\Admin\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\FileUpload;
use App\Helpers\ArabicSlugHelper;
use App\Models\BlogPost;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات المقال')
                    ->description('أدخل تفاصيل المقال الأساسية هنا.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('عنوان المقال')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $set(
                                            'slug',
                                            ArabicSlugHelper::unique(
                                                $state,
                                                BlogPost::class,
                                                'slug',
                                                $get('id')
                                            )
                                        );
                                    }),
                                TextInput::make('slug')
                                    ->label('الرابط المختصر')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                            ]),
                        Textarea::make('content')
                            ->label('المحتوى')
                            ->rows(10)
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->label('الصورة البارزة')
                            ->image()
                            ->directory('blog'),
                    ]),

                Section::make('الإعدادات والنشر')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_published')
                                    ->label('تم النشر')
                                    ->required(),
                                DateTimePicker::make('published_at')
                                    ->label('تاريخ النشر')
                                    ->default(now()),
                                Placeholder::make('user_name')
                                    ->label('الكاتب')
                                    ->content(fn () => auth()->user()?->name ?? 'غير معروف'),
                                Hidden::make('user_id')
                                    ->default(fn () => auth()->id())
                                    ->required(),
                            ]),
                    ]),

                Section::make('تنسيق الخط')
                    ->description('تحكم في حجم ونوع الخط لمحتوى المقال.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('content_font_family')
                                    ->label('نوع الخط')
                                    ->options([
                                        'Cairo' => 'Cairo (الافتراضي)',
                                        'Tajawal' => 'Tajawal',
                                        'Almarai' => 'Almarai',
                                        'IBM Plex Sans Arabic' => 'IBM Plex Sans Arabic',
                                        'sans-serif' => 'Sans Serif',
                                        'serif' => 'Serif',
                                    ])
                                    ->default('Cairo'),
                                Select::make('content_font_size')
                                    ->label('حجم الخط')
                                    ->options([
                                        '1rem' => 'صغير (16px)',
                                        '1.125rem' => 'عادي (18px)',
                                        '1.25rem' => 'متوسط (20px)',
                                        '1.375rem' => 'كبير (22px)',
                                        '1.5rem' => 'كبير جداً (24px)',
                                    ])
                                    ->default('1.125rem'),
                            ]),
                    ]),

                Section::make('تحسين محركات البحث (SEO)')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('عنوان الميتا')
                            ->default(null),
                        Textarea::make('meta_description')
                            ->label('وصف الميتا')
                            ->default(null),
                        TextInput::make('meta_keywords')
                            ->label('الكلمات المفتاحية')
                            ->placeholder('كلمة، كلمة، كلمة')
                            ->default(null),
                    ]),
            ]);
    }
}
