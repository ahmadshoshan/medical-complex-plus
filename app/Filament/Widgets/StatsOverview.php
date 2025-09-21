<?php

namespace App\Filament\Widgets;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Room;
use App\Models\WaitingList;
use Clue\Redis\Protocol\Model\Request;
use Filament\Infolists\Components\TextEntry;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\On;

class StatsOverview extends BaseWidget

{
    public function getColumns(): int | array
    {
        return 3;
    }
    // protected static bool $isDiscovered = false;

    protected ?string $pollingInterval = null;


    protected int $Waiting;
    protected int $room =0;
    protected int $patientNumber=0;
    public function __construct()
    {
        $this->Waiting = WaitingList::where('status', 'waiting')->count();
    }


    protected function getStats(): array

    {
        return [


            Stat::make(now(),
            '
             الحالة رقم ' .$this->patientNumber.
             '
            بالغرفة    ' .$this->room.
            ''
            )
                // ->value(1000)
                ->descriptionIcon('heroicon-o-user', 'before')
                ->description('الحالة التالية رقم ' . ($this->patientNumber + 1) . ' ')
                ->color('success')->dehydrated()
                ->chart([7, 3, 4, 5, 3, 5, 3]),
            Stat::make(' الاطباء', Doctor::where('is_active', true)->count())
                // ->value(1000)
                ->descriptionIcon('heroicon-o-user', 'before')
                ->description(' الاطباء المتاحه')
                ->color('success')->dehydrated()
                ->chart([7, 3, 4, 5, 3, 5, 3]),
            Stat::make('حالات الانتظار',   $this->Waiting)
                ->descriptionIcon('heroicon-o-numbered-list', 'before')
                ->description('إجمالي حالات  الانتظار')
                ->color('success')->dehydrated()
                ->chart([$this->Waiting * 2, 3, 4, 5, 3, 5, 3])
                ->url(route('filament.admin.resources.waiting-lists.index')) // أو أي رابط تريده
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:underline', // لجعل التفاعل أوضح
                ]),

        ];
    }


    // ✅ الاستماع للحدث
    protected $listeners = [
        'echo:admin-stats,StatsUpdated' => 'refreshStats',
        'echo:waiting-room,CallPatient' => 'refreshStats'
    ];
    #[
        On('echo:admin-stats,StatsUpdated'),
        On('echo:waiting-room,CallPatient')

        ]
    // 🚀 دالة التحديث
    public function refreshStats($data)
    {

        // dd($data['roomNumber']);
        $this->room=$data['roomNumber']??0;
        $this->patientNumber=$data['patientNumber']??0;

        $this->dispatch('refreshStats');
    }
    public static function canView(): bool
{
    return true; // السماح للجميع بالعرض
}
}
