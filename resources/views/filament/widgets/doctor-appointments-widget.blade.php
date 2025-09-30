
<x-filament-widgets::widget>

        <div class="relative bg-white rounded-xl shadow p-4 overflow-hidden ">
            <!-- <h2 class='text-lg font-bold mb-3'>⏰ مواعيد الأطباء</h2> -->

            <!-- الشريط المتحرك -->
            <div class="marquee">
                <div class="marquee-content">
                    @foreach($this->getAppointments() as $appointment)
                        <span class="mx-4 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm inline-block">
                            👨‍⚕️  {{"د.". $appointment->doctor->name ?? 'طبيب غير محدد' }}
                            📅 {{ $appointment->days_list }}
                            ⏰ من {{ $appointment->start_time ? \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') : '--' }}
                            إلى {{ $appointment->end_time ? \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') : '--' }} ---------------
                        </span>
                    @endforeach
                </div>
            </div>
        </div>


    <style>
        .marquee-content span {
    font-size: 30px; /* أو 20px, 22px حسب اللي يعجبك */
}
.marquee  {
    margin-top: -10px; /* ارفعها 10px لفوق */
}
        .marquee {
            position: relative;
            width: 100%;
            overflow: hidden; /* عشان النص ما يطلعش بره */
            white-space: nowrap; /* كل النص في سطر واحد */
        }

        .marquee-content {
            display: inline-block;
            /* padding-left: 100%; يبدأ من بره */
            animation: marquee 25s linear infinite;
        }

        @keyframes marquee {
            0%   { transform: translateX(-0); }
            100% { transform: translateX(70%); }
        }
    </style>
</x-filament-widgets::widget>

