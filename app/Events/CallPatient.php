<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallPatient implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $patientNumber, $roomNumber,$doctorName, $doctorSpecialty;

    public function __construct($patientNumber, $roomNumber,$doctorName, $doctorSpecialty)
    {
        $this->patientNumber = $patientNumber;
        $this->roomNumber = $roomNumber;
        $this->doctorName = $doctorName;
        $this->doctorSpecialty = $doctorSpecialty;

    }

    public function broadcastOn()
    {
        return new Channel('waiting-room'); // يجب أن تكون public
    }

    // public function broadcastAs()
    // {
    //     return 'CallPatient'; // مطابق لما تستمع له
    // }
}
