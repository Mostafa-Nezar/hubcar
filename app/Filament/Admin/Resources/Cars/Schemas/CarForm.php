<?php

namespace App\Filament\Admin\Resources\Cars\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\KeyValue;
use Filament\Schemas\Schema;
use App\Models\CarModel;
use App\Models\CarCategory;
use App\Helpers\ArabicSlugHelper;
use App\Models\Car;

class CarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات أساسية')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('اسم السيارة')
                                    ->required()
                                    ->maxLength(255)
                                    ->regex('/^[\p{Arabic}\p{Latin}0-9\s\-]+$/u') // يمنع الرموز الغريبة
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $set(
                                            'slug',
                                            ArabicSlugHelper::unique(
                                                $state,
                                                Car::class,
                                                'slug',
                                                $get('id')
                                            )
                                        );
                                    }),
                                TextInput::make('slug')
                                    ->label('الرابط (Slug)')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Select::make('brand_id')
                                    ->label('الماركة')
                                    ->relationship('brand', 'name')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn ($set) => $set('type', null))
                                    ->searchable()
                                    ->preload(),
                                Select::make('type')
                                    ->label('نوع السيارة')
                                    ->options(function ($get) {
                                        $brandId = $get('brand_id');
                                        if (!$brandId) return [];
                                        return CarModel::where('brand_id', $brandId)->pluck('name', 'name')->toArray();
                                    })
                                    ->live()
                                    ->afterStateUpdated(fn ($set) => $set('category', null))
                                    ->required(),
                                Select::make('category')
                                    ->label('الفئة')
                                    ->options(function ($get) {
                                        $brandId = $get('brand_id');
                                        $typeName = $get('type');
                                        if (!$brandId || !$typeName) return [];
                                        $model = CarModel::where('brand_id', $brandId)->where('name', $typeName)->first();
                                        if (!$model) return [];
                                        return CarCategory::where('car_model_id', $model->id)->pluck('name', 'name')->toArray();
                                    }),
                                Select::make('model_year')
                                    ->label('سنة الموديل')
                                    ->options(array_combine(range(2020, 2027), range(2020, 2027)))
                                    ->required(),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('price')
                                            ->label('السعر قبل الخصم')
                                            ->numeric()
                                            ->minValue(0)
                                            ->required()
                                            ->helperText('يظهر كالسعر الأصلي مشطوباً في حال وجود خصم'),
                                        TextInput::make('discount_price')
                                            ->label('السعر بعد الخصم (العرض)')
                                            ->numeric()
                                            ->minValue(0)
                                            ->rule(function ($get) {
                                                $price = $get('price');
                                                return $price
                                                    ? fn ($attribute, $value, $fail) => $value > $price ? $fail('السعر بعد الخصم لا يمكن أن يكون أكبر من السعر الأصلي.') : true
                                                    : true;
                                            })
                                            ->helperText('اتركه فارغاً إذا لا يوجد عرض'),
                                    ]),
                            ]),
                    ]),

                Section::make('الحالة والمواصفات')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('condition')
                                    ->label('الحالة')
                                    ->options([
                                        'new' => 'جديدة',
                                        'used' => 'مستعملة',
                                    ])
                                    ->default('new')
                                    ->required(),
                                Select::make('availability_status')
                                    ->label('حالة التوفر')
                                    ->options([
                                        'available' => 'متوفرة',
                                        'sold' => 'مباعة',
                                        'reserved' => 'محجوزة',
                                    ])
                                    ->default('available')
                                    ->required(),
                                Toggle::make('is_featured')
                                    ->label('عرض في الواجهة')
                                    ->default(false),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('seats')
                                    ->label('عدد المقاعد')
                                    ->numeric()
                                    ->minValue(2)
                                    ->maxValue(8)
                                    ->required()
                                    ->helperText('عدد المقاعد يجب أن يكون بين 2 و 8'),
                                Select::make('transmission')
                                    ->label('ناقل الحركة')
                                    ->options([
                                        'automatic' => 'أتوماتيك',
                                        'manual' => 'يدوي',
                                    ])
                                    ->required(),
                                Select::make('fuel_type')
                                    ->label('نوع الوقود')
                                    ->options([
                                        'gasoline' => 'بنزين',
                                        'diesel' => 'ديزل',
                                        'hybrid' => 'هايبرد',
                                        'electric' => 'كهرباء',
                                    ])
                                    ->required(),
                            ]),
                    ]),

                Section::make('الصور والوسائط')
                    ->schema([
                        FileUpload::make('main_image')
                            ->label('الصورة الرئيسية')
                            ->disk('public')
                            ->image()
                            ->directory('cars')
                            ->required(),
                        Repeater::make('images')
                            ->label('معرض الصور')
                            ->relationship('images')
                            ->schema([
                                FileUpload::make('path')
                                    ->label('الصورة')
                                    ->disk('public')
                                    ->image()
                                    ->directory('cars/gallery')
                                    ->required(),
                                TextInput::make('sort_order')
                                    ->label('الترتيب')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns(2)
                            ->grid(2),
                    ]),

                Section::make('الوصف والمواصفات التفصيلية')
                    ->schema([
                        Textarea::make('description')
                            ->label('الوصف')
                            ->rows(5)
                            ->maxLength(2000)
                            ->required()
                            ->regex('/^[\p{Arabic}\p{Latin}0-9\s.,\-]+$/u'), // منع الرموز الغريبة
                        Textarea::make('other_specs')
                            ->label('مواصفات إضافية')
                            ->rows(3)
                            ->maxLength(1000)
                            ->regex('/^[\p{Arabic}\p{Latin}0-9\s.,\-]+$/u'),
                        KeyValue::make('specs')
                            ->label('المواصفات الفنية')
                            ->keyLabel('المواصفة')
                            ->valueLabel('القيمة')
                            ->reorderable(),
                    ]),
            ]);
    }
}