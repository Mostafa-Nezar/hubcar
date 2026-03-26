<?php

namespace App\Filament\Admin\Resources\AboutPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AboutPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('العناوين والنصوص')
                    ->schema([
                        TextInput::make('title')
                            ->label('العنوان الرئيسي')
                            ->required(),
                        TextInput::make('subtitle')
                            ->label('عنوان فرعي')
                            ->default(null),
                        Textarea::make('description_1')
                            ->label('الوصف الأول')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        Textarea::make('description_2')
                            ->label('الوصف الثاني (اختياري)')
                            ->default(null)
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
                \Filament\Schemas\Components\Section::make('الإحصائيات')
                    ->columns(2)
                    ->schema([
                        TextInput::make('exp_label')
                            ->label('تسمية سنوات الخبرة')
                            ->required()
                            ->default('عاماً من الخبرة'),
                        TextInput::make('exp_value')
                            ->label('قيمة سنوات الخبرة')
                            ->required()
                            ->default('15+'),
                        TextInput::make('clients_label')
                            ->label('تسمية عدد العملاء')
                            ->required()
                            ->default('عميل سعيد'),
                        TextInput::make('clients_value')
                            ->label('قيمة عدد العملاء')
                            ->required()
                            ->default('5000+'),
                    ]),
                \Filament\Schemas\Components\Section::make('الوسائط')
                    ->schema([
                        FileUpload::make('image')
                            ->label('الصورة الرئيسية')
                            ->disk('public')
                            ->image()
                            ->directory('about'),
                    ]),
                \Filament\Schemas\Components\Section::make('المميزات (Bullet Points)')
                    ->description('تظهر هذه النقاط في الصفحة الرئيسية تحت قسم من نحن')
                    ->schema([
                        TextInput::make('feature_1')
                            ->label('الميزة الأولى')
                            ->default('أفضل الأسعار التنافسية في السوق'),
                        TextInput::make('feature_2')
                            ->label('الميزة الثانية')
                            ->default('فحص شامل ومعايير جودة صارمة'),
                        TextInput::make('feature_3')
                            ->label('الميزة الثالثة')
                            ->default('خيارات تمويل متعددة وميسرة'),
                    ]),
            ]);
    }
}
