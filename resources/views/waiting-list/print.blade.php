<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>طباعة الحالة</title>
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            direction: rtl;
            text-align: right;
        }

        .ticket {
            width: 350px;
            border: 2px dashed #000;
            padding: 15px;
            margin: auto;
        }

        h2,
        h3 {
            margin: 5px 0;
            text-align: center;
        }

        p {
            margin: 3px 0;
        }
    </style>
    <script>
        window.onload = function() {
            window.print();

            // بعد ما المستخدم يقفل شاشة الطباعة يرجع للقائمة
            window.onafterprint = function() {
                window.location.href = "{{ route('filament.admin.resources.waiting-lists.index') }}";
            };
        }
    </script>
</head>

<body>
    <div class="ticket">
        <h2>المجمع الطبي</h2>
        <h3>تذكرة الانتظار</h3>
        <hr>
        <p><strong>رقم الانتظار:</strong> {{ $record->queue_number }}</p>

        {{-- باركود --}}
        <div style="text-align:center; margin:10px 0;">
{!! QrCode::size(150)->generate((string) $record->queue_number) !!}


            <br>
            <small>{{ $record->queue_number }}</small>
        </div>

        <hr>
        <p><strong>الاسم:</strong> {{ $record->patient?->name }}</p>
        <p><strong>رقم الانتظار:</strong> {{ $record->queue_number }}</p>
        <p><strong>الطبيب:</strong> {{ $record->doctor?->name }}</p>
        <p><strong>التخصص:</strong> {{ $record->doctor?->specialty ?? '-' }}</p>
        <p><strong>الغرفة:</strong> {{ $record->room?->room_number }}</p>
        <p><strong>الوقت:</strong> {{ $record->arrival_time?->format('h:i A d-m-Y') }}</p>
        <hr>
        <p style="text-align:center;">شكراً لزيارتكم</p>
    </div>
    <script>
    window.onload = function () {
        window.print();

        // بعد الطباعة مباشرة يرجع للقائمة
        window.onafterprint = function () {
            window.location.href = "{{ route('filament.admin.resources.waiting-lists.index') }}";
        };
    }
</script>

</body>

</html>
