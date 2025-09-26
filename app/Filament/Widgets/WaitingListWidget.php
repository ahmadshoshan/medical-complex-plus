<?php



namespace App\Filament\Widgets;

use App\Filament\Resources\WaitingLists\WaitingListResource as WaitingListsWaitingListResource;
use Filament\Forms\Components\Builder;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Widgets\TableWidget as BaseWidget;
use Livewire\Attributes\On;

class WaitingListWidget extends BaseWidget

{
   // ✨ تغيير العنوان اللي بيظهر فوق الودجت
    protected static ?string $heading = 'قائمة الانتظار';
    protected ?string $pollingInterval = null;

    protected static bool $isDiscovered = false;
    public static function shouldRegisterNavigation(): bool
    {
        return false; // مش هيظهر في النافيجيشن
    }
    protected static ?string $pluralModelLabel = 'قوائم انتظار'; // اسم العرض في القائمة
    public function table(Table $table): Table
    {
        return $table
            ->query(
                WaitingListsWaitingListResource::getEloquentQuery()->where('status', 'waiting')
            )
            ->defaultPaginationPageOption(5)
            // ->paginated(false) // ✅ إلغاء شريط التنقل
             ->heading('') // ✅ إلغاء العنوان العلوي
            ->columns([
                Tables\Columns\TextColumn::make('queue_number')->label('رقم الحالة'),
                // Tables\Columns\TextColumn::make('patient.name')->label('الاسم'),
                Tables\Columns\TextColumn::make('doctor.name')->label('الطبيب'),
                Tables\Columns\TextColumn::make('room.room_number')->label('الغرفة'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'waiting' => 'في الانتظار',
                        'in_progress' => 'جاري الكشف',
                        'completed' => 'مكتمل',
                        'canceled' => 'ملغي',
                        default => ucfirst($state), // احتياطي
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'waiting' => 'warning',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'canceled' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('arrival_time')->label('وقت الوصول')->time('i h A'),
            ]);
    }


    // داخل الكلاس
    protected $listeners = [
        'echo:waiting-list,WaitingListUpdated' => 'handleUpdate'
    ];

    #[On('echo:waiting-list,WaitingListUpdated')]
    public function handleUpdate($data)
    {
        $this->dispatch('refreshTable');
    }



    public function getData()
    {
        return WaitingListsWaitingListResource::getEloquentQuery()
            ->where('status', 'waiting')
            ->get();
    }
}
