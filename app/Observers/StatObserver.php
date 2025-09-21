<?php

namespace App\Observers;

use App\Models\Patient;

class StatObserver
{
    public function created(Patient $patient)
    {
        $this->broadcast();
    }
    // public function updated(Patient $patient)
    // {
    //     $this->broadcast();
    // }
    public function deleted(Patient $patient)
    {
        $this->broadcast();
    }

    protected function broadcast()
    {
        \App\Events\StatsUpdated::dispatch();
    }
}
