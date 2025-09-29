<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>تذكرة الانتظار</title>
    <style>
        @page {
            size: 80mm auto;
            /* مقاس الورق عرض 80mm وطول تلقائي */
            margin: 0;
            /* إلغاء الهوامش كلها */
        }



        body {
            font-family: 'Tahoma', sans-serif;
            /* direction: rtl; */
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .ticket {

            width: 80mm;
            /* مقاس ورق الطابعة */
            /* padding: 10px; */
            margin: auto;
            /* border: 2px dashed #000; */
        }

        h2,
        h3 {
            margin: 5px 0;
            font-size: 16px;
        }

        p {
            margin: 3px 0;
            font-size: 14px;
        }



        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .ticket {
                border: none;
                /* لو مش عايز يطبع البوردر */
            }
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.location.href = "{{ route('filament.admin.resources.waiting-lists.index') }}";
            };
        }
    </script>
</head>

<body>
    <div class="ticket">
        <div class="qrcode">
            {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(120)->generate((string) $record->queue_number) !!}
            <!-- <small>{{ $record->queue_number }}</small> -->
        </div>
        <h2>مجمع عيادات ابوغنيمة</h2>
        <h2>01097722496</h2>
        <h3>تذكرة الانتظار</h3>
        <hr>
        <p><strong>رقم:</strong> {{ $record->queue_number }}</p>
        <hr>
        <p><strong>الاسم:</strong> {{ $record->patient?->name }}</p>
        <p><strong>الطبيب:</strong> {{ $record->doctor?->name }}</p>
        <p><strong>التخصص:</strong> {{ $record->doctor?->specialty ?? '-' }}</p>
        <p><strong>الغرفة:</strong> {{ $record->room?->room_number }}</p>
        <p><strong>الوقت:</strong> {{ $record->arrival_time?->format('h:i A d-m-Y') }}</p>
        <hr>
        <p>شكراً لزيارتكم</p>
    </div>
</body>

</html>
