<?php

namespace App\Filament\Admin\Resources\BookingRequests\Schemas;

use App\Models\Car;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookingRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات العميل')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('client_name')
                                    ->label('اسم العميل')
                                    // 3 to 6 Arabic name parts separated by spaces (Saudi ID style)
                                    ->regex('/^\p{Arabic}+(?:\s+\p{Arabic}+){2,5}$/u')
                                    ->helperText('مثال: أحمد محمد علي (٣ أسماء على الأقل) حتى ٦ أسماء')
                                    ->required(),
                                TextInput::make('phone')
                                    ->label('رقم الجوال')
                                    ->tel()
                                    ->maxLength(20)
                                    // Saudi mobile formats: 05xxxxxxxx | +9665xxxxxxxx | 009665xxxxxxxx
                                    ->regex('/^(?:\+?966|00966|0)?5[0-9]{8}$/')
                                    ->helperText('مثال: 05xxxxxxxx أو +9665xxxxxxxx أو 009665xxxxxxxx')
                                    ->required(),
                                TextInput::make('email')
                                    ->label('البريد الإلكتروني')
                                    ->email()
                                    ->maxLength(255)
                                    ->nullable(),
                                TextInput::make('city')
                                    ->label('المدينة')
                                    ->maxLength(100)
                                    ->required(),
                            ]),
                    ]),

                Section::make('معلومات السيارة')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('car_id')
                                    ->label('السيارة')
                                    ->relationship('car', 'name')
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('car_name_manual')
                                    ->label('اسم السيارة (يدوياً)')
                                    ->helperText('يستخدم في حال حذف سجل السيارة'),
                                TextInput::make('brand_name')
                                    ->label('الماركة'),
                                TextInput::make('car_type')
                                    ->label('النوع'),
                                TextInput::make('car_category')
                                    ->label('الفئة'),
                                TextInput::make('model_year')
                                    ->label('سنة الصنع')
                                    ->numeric(),
                                TextInput::make('car_price')
                                    ->label('السعر نقداً')
                                    ->numeric()
                                    ->prefix('ر.س'),
                            ]),
                    ]),

                Section::make('تفاصيل الطلب والتمويل')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('payment_type')
                                    ->label('نوع الدفع')
                                    ->options([
                                        'cash' => 'كاش',
                                        'finance' => 'تمويل',
                                    ])
                                    ->required()
                                    ->live(),
                                TextInput::make('bank_name')
                                    ->label('اسم البنك')
                                    ->maxLength(100)
                                    ->visible(fn ($get) => $get('payment_type') === 'finance')
                                    ->required(fn ($get) => $get('payment_type') === 'finance'),
                                Select::make('work_sector')
                                    ->label('قطاع العمل')
                                    ->options([
                                        'govt' => 'حكومي',
                                        'private' => 'خاص',
                                        'military' => 'عسكري',
                                        'retired' => 'متقاعد',
                                    ])
                                    ->visible(fn ($get) => $get('payment_type') === 'finance')
                                    ->required(fn ($get) => $get('payment_type') === 'finance'),
                                TextInput::make('monthly_salary')
                                    ->label('الراتب الشهري')
                                    ->numeric()
                                    ->minValue(0)
                                    ->visible(fn ($get) => $get('payment_type') === 'finance')
                                    ->required(fn ($get) => $get('payment_type') === 'finance'),
                                TextInput::make('monthly_installment')
                                    ->label('القسط الشهري')
                                    ->numeric()
                                    ->minValue(0)
                                    ->visible(fn ($get) => $get('payment_type') === 'finance'),
                                TextInput::make('down_payment')
                                    ->label('الدفعة المقدمة')
                                    ->numeric()
                                    ->minValue(0)
                                    ->visible(fn ($get) => $get('payment_type') === 'finance'),
                                TextInput::make('finance_period')
                                    ->label('مدة التمويل (شهر)')
                                    ->numeric()
                                    ->minValue(1)
                                    ->visible(fn ($get) => $get('payment_type') === 'finance'),
                                DateTimePicker::make('request_date')
                                    ->label('تاريخ الطلب')
                                    ->default(now())
                                    ->required(),
                            ]),
                    ]),

                Section::make('الحالة والمتابعة')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('status')
                                    ->label('حالة الطلب')
                                    ->options([
                                        'New' => 'جديد',
                                        'Contacted' => 'تم التواصل',
                                        'Interested' => 'مهتم',
                                        'Not Interested' => 'غير مهتم',
                                        'Completed' => 'مكتمل',
                                    ])
                                    ->required()
                                    ->default('New'),
                                Placeholder::make('last_status_update')
                                    ->label('تاريخ آخر تحديث للحالة')
                                    ->content(fn ($record) => $record?->last_status_update?->format('d/m/Y H:i A') ?? '---')
                                    ->visible(fn ($record) => $record !== null),
                                Placeholder::make('updated_by_name')
                                    ->label('الموظف الذي قام بالتحديث')
                                    ->content(fn ($record) => $record?->updater?->name ?? '---')
                                    ->visible(fn ($record) => $record !== null),
                            ]),
                    ]),

                Section::make('ملاحظات')
                    ->schema([
                        Textarea::make('client_notes')
                            ->label('ملاحظات العميل')
                            ->rows(3),
                        Textarea::make('internal_notes')
                            ->label('ملاحظات داخلية (خاصة بالموظفين)')
                            ->rows(3),
                    ]),
            ]);
    }
}
