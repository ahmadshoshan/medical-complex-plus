<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatsUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $stats;

    // public function __construct()
    // {
    //     $this->stats = [
    //         // 'doctors' => \App\Models\Doctor::count(),
    //         'patients' => \App\Models\Patient::count(),
    //         'waiting_lists' => \App\Models\WaitingList::count(),
    //     ];
    // }

    public function broadcastOn()
    {

        return new Channel('admin-stats'); // قناة عامة
    }

    // public function broadcastAs()
    // {
    //     return 'updated';
    // }
}
