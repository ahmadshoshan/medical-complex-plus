<?php

namespace App\Filament\Widgets;

use App\Models\AppointmentDoctors;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class DoctorAppointmentsWidget extends Widget
{
    protected  string $view = 'filament.widgets.doctor-appointments-widget';
    protected int|string|array $columnSpan = 'full'; // ياخد العرض كله في الداشبورد
  protected static bool $isDiscovered = false;
    protected ?string $pollingInterval = null;



    public function getAppointments()
    {
        return AppointmentDoctors::with('doctor') // لو عندك علاقة Doctor
            ->latest()
            ->take(20)
            ->get();
    }


    protected $listeners = ['echo:DoctorAppointmentsChannel,DoctorAppointmentsEvent' => 'refreshStats'];
    #[On('echo:DoctorAppointmentsChannel,CallPatient')]
    // 🚀 دالة التحديث
    public function refreshStats($data)
    {
        // dd($data['roomNumber']);
        $this->dispatch('refreshStats');
    }
}
