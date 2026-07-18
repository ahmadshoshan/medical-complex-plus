<?php

namespace App\Observers;

use App\Models\AppointmentDoctors;

class DoctorAppointmentsObserver
{
    public function created(AppointmentDoctors $AppointmentDoctors)
    {
        $this->broadcast();
    }
    public function updated(AppointmentDoctors $AppointmentDoctors)
    {
        $this->broadcast();
    }
    public function deleted(AppointmentDoctors $AppointmentDoctors)
    {
        $this->broadcast();
    }

    protected function broadcast()
    {
        \App\Events\DoctorAppointmentsEvent::dispatch();
    }
}
