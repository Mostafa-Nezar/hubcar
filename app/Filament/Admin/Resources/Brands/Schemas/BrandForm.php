<?php

namespace App\Filament\Admin\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الماركة')
                    ->description('أدخل اسم الماركة وشعارها الرسمي')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('اسم الماركة')
                                    ->placeholder('مثلاً: تويوتا، لاند روفر')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                FileUpload::make('logo')
                                    ->label('الشعار')
                                    ->image()
                                    ->directory('brands')
                                    ->imageEditor(),
                            ]),
                    ]),

                Section::make('الموديلات والفئات')
                    ->description('إدارة موديلات هذه الماركة والفئات التابعة لكل موديل')
                    ->schema([
                        Repeater::make('models')
                            ->label('قائمة الموديلات')
                            ->relationship('models')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('اسم الموديل/النوع')
                                            ->placeholder('مثلاً: كامري، كورولا')
                                            ->required()
                                            ->columnSpanFull(),
                                        
                                        Repeater::make('categories')
                                            ->label('الفئات المتاحة لهذا الموديل')
                                            ->relationship('categories')
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('اسم الفئة')
                                                    ->placeholder('مثلاً: GLE, SE, ستاندرد')
                                                    ->required(),
                                            ])
                                            ->grid(3)
                                            ->reorderable()
                                            ->addActionLabel('إضافة فئة جديدة')
                                            ->columnSpanFull()
                                            ->collapsible(),
                                    ]),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->collapsible()
                            ->collapsed(false)
                            ->cloneable()
                            ->addActionLabel('إضافة موديل جديد')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
