<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WaitingListUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   public $waitingList;

    // public function __construct($waitingList)
    // {
    //     $this->waitingList = $waitingList;
    // }

    public function broadcastOn()
    {
        // dd('ssss');
        return new Channel('waiting-list'); // قناة عامة
    }



    // public function broadcastWith()
    // {
    //     return [
    //         'id' => $this->waitingList->id,
    //         'patient_name' => $this->waitingList->patient->name,
    //         'status' => $this->waitingList->status,
    //         'room_number' => $this->waitingList->room->room_number,
    //         'queue_number' => $this->waitingList->queue_number,
    //     ];
    // }
}
