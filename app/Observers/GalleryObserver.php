<?php

namespace App\Observers;

use App\Models\Gallery;

class GalleryObserver
{
    public function created(Gallery $Gallery)
    {
        $this->broadcast();
    }
    public function updated(Gallery $Gallery)
    {
        $this->broadcast();
    }
    public function deleted(Gallery $Gallery)
    {
        $this->broadcast();
    }

    protected function broadcast()
    {
        \App\Events\GalleryEvent::dispatch();
    }




}
