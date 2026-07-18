<?php

namespace App\Filament\Resources\Doctors\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AppointmentDoctorsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointment_doctors';
    protected static ?string $navigationLabel = 'المواعيد';
 // ✅ أضف هذه الدالة لتغيير الترجمة
//   public static function getLabel(): string
//     {
//         return 'الموعد';
//     }

//     public static function getPluralLabel(): string
//     {
//         return 'المواعيد';
//     }

    public static function getModelLabel(): string
    {
        return 'موعد طبيب';
    }

    public static function getPluralModelLabel(): string
    {
        return 'مواعيد الأطباء';
    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('days')
                    ->label('اليوم')
                    ->options([
                      "السبت"   =>   "السبت",
                      "الأحد"   =>   "الأحد",
                      "الإثنين" =>   "الإثنين",
                      "الثلاثاء"=>   "الثلاثاء",
                      "الأربعاء"=>   "الأربعاء",
                      "الخميس"  =>   "الخميس",
                      "الجمعة"  =>   "الجمعة",
                    ])
                    ->multiple() // يسمح باختيار أكثر من يوم
                    ->searchable()
                    ->required()
                    ->native(false), // لتحسين الشكل في الواجهة
                TimePicker::make('start_time')->label('من'),
                TimePicker::make('end_time')->label('الي'),

                Textarea::make('notes')->label('ملاحظة')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('start_time')
            ->columns([

                TextColumn::make('days')
                    ->label('الأيام')

                    ->badge()
                    ->colors(['primary']),

                TextColumn::make('StartTime12')->label('من')

                    ->sortable(),
                TextColumn::make('EndTime12')->label('الي')

                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()

                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()

                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
