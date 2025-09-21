<?php

namespace App\Filament\Widgets;


use App\Models\Room;
use App\Models\WaitingList;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\On;

class StatsDoctor extends BaseWidget

{

    // protected static ?int $sort = 3;
    public int $roomNumber = 0;
    public int $patientNumber = 0;
    protected static bool $isDiscovered = false;
    protected ?string $pollingInterval = null;


    public function getColumns(): int | array
    {
        return 6;
    }

    protected function getStats(): array
    {
        // جلب أول 6 غرف (أو كلها مع تحديد 6 فقط)
        $rooms = Room::with('doctor')->orderBy('room_number')->limit(6)->get();



        $stats = [];

        // إنشاء 6 إحصائيات (غرف من 1 إلى 6)
        foreach ($rooms as $room) {
            // الوصول إلى الطبيب المرتبط بالغرفة
            $doctor = $room->doctor;

            if (!$doctor) {
                $description = 'لا يوجد طبيب';
                $specialty = 'مغلق';
                $color = 'secondary';
                $icon = 'heroicon-m-x-circle';
            } else {
                // جلب أول مريض جاري الكشف عند الطبيب

                $currentPatient = WaitingList::where('doctor_id', $doctor->id)
                    ->where('status', 'in_progress')->first();
                //  dd($currentPatient);

                if ($doctor->is_active) {
                    if ($currentPatient) {
                        $description = "🔵د. {$doctor->name} يستقبل الحالة رقم {$currentPatient->queue_number}";
                        $color = 'info'; // 🔵 أزرق للإشارة إلى النشاط الحالي
                        $icon = 'heroicon-m-user-circle';
                    } else {
                        $description = "🟢د. {$doctor->name} - متاح";
                        $color = 'success'; // 🟢 أخضر للإتاحة العادية
                        $icon = 'heroicon-m-check-circle';
                    }
                } else {
                    $description = "🟡د. {$doctor->name} - غير متاح";
                    $color = 'warning'; // 🟡 أصفر
                    $icon = 'heroicon-m-eye-slash';
                }
                $specialty = $doctor->specialty;
            }










            $stats[] = Stat::make("الغرفة {$room->room_number}",  $specialty)
                ->description($description)
                ->color($color)

                ->url(route('filament.admin.resources.rooms.edit', $room))
                //  ->url(route('filament.admin.resources.waiting-lists.index')) // أو أي رابط تريده

                ->icon($icon)
                ;
        }

        return $stats;
    }




    protected $listeners = [
        // 'echo:admin-stats,StatsUpdated' => 'refreshStats',
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
        $this->roomNumber = $data['roomNumber'] ?? 0;
        $this->patientNumber = $data['patientNumber'] ?? 0;

        // $this->dispatch('refreshStats');
    }









    public static function canView(): bool
    {
        return true; // السماح للجميع بالعرض
    }

    public function getData()
    {
        return $this->getStats(); // تُرجع المصفوفة من Stat::make(...)
    }
}
