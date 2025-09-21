<?php

namespace App\Filament\Widgets;

use App\Models\Gallery;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class GallerySlider2 extends Widget
{
      protected static bool $isDiscovered = false;
    protected ?string $pollingInterval = null;

    protected  string $view = 'filament.widgets.gallery-slider2';

    protected int | string | array $columnSpan = 'full';

    public function getRecords()
    {
         return Gallery::query()
            ->latest()
            ->get()
            ->map(fn ($gallery) => [
                'src' => asset('storage/' . $gallery->image),  // تحويل الصورة
                'caption' => $gallery->title ?? '',            // العنوان
            ])
            ->toArray();

    }

      protected $listeners = ['echo:GalleryChannel,GalleryEvent' => 'refreshStats'];
    #[On('echo:GalleryChannel,GalleryEvent')]
    // 🚀 دالة التحديث
    public function refreshStats($data)
    {
        // dd($data['roomNumber']);
        $this->dispatch('refreshStats');
    }




}
