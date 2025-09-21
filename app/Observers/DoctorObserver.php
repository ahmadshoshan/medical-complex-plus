<?php

namespace App\Observers;

use App\Models\Doctor;

class DoctorObserver
{
    public function created(Doctor $Doctor)
    {
        $this->broadcast();
    }
    public function updated(Doctor $Doctor)
    {
        $this->broadcast();
    }
    public function deleted(Doctor $Doctor)
    {
        $this->broadcast();
    }

    protected function broadcast()
    {
        \App\Events\StatsUpdated::dispatch();
        \App\Events\WaitingListUpdated::dispatch();
    }
}
