<?php

namespace App\Observers;


use App\Models\Room;
use Filament\Notifications\Notification;

class RoomObserver
{
    public function created(Room $Room)
    {

      

        $this->broadcast();
    }
    public function updated(Room $Room)
    {
      

        $this->broadcast();
    }
    public function deleted(Room $Room)
    {
    
        $this->broadcast();
    }

    protected function broadcast()
    {
      \App\Events\StatsUpdated::dispatch();
        \App\Events\WaitingListUpdated::dispatch();
    
    }
}
