<?php

namespace App\Http\Controllers;

use App\Filament\Widgets\StatsDoctor;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\WaitingListWidget;
use Illuminate\Http\Response;


class PublicTvController extends Controller
{
    public function show()
    {


        $widget = new StatsDoctor();
        $StatsDoctor = $widget->getData(); // ← نحصل على البيانات فقط
        $widget2 = new WaitingListWidget();
        $StatsWaitingList = $widget2->getData(); // ← نحصل على البيانات فقط

        return view('components.public-tv-screen', compact(['StatsDoctor','StatsWaitingList']));
    }
}
