<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>شاشة العرض</title>

    <style>
        body {
            margin: 0;
            padding: 1rem;
            background: #000309;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }

        .container {
            /* max-width: 1200px; */
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #18181b;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-title {
            font-size: 0.875rem;
            color: #ebffff;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #ffb900;
        }

        .stat-description {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #ffb900;
        }

        .success {
            color: #05df72;
        }

        .info {
            color: #0284c7;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-3xl font-bold text-center mb-8">مجمع ابوغنيمة الطبي </h1>
        <!-- عرض الإحصائيات -->
        <div class="stats-grid">
            @foreach($StatsDoctor as $stat)
            <div class="stat-card">
                <div class="stat-title">{{ $stat->getlabel() }}</div>
                <div class="stat-value {{ $stat->getColor() }}">
                    {{ $stat->getValue() }}
                </div>
                @if($description = $stat->getDescription())
                <div class="stat-description {{ $stat->getColor() }}">
                    {{ $description }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    <!-- قائمة الانتظار -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">

            قائمة الانتظار
        </h2>
        @if($StatsWaitingList->isEmpty())
        <p class="text-center text-gray-500 text-lg py-8 bg-gray-50 rounded-lg">
            لا يوجد مرضى في الانتظار حاليًا
        </p>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        <th class="px-4 py-3">الرقم</th>
                        <th class="px-4 py-3">الطبيب</th>
                        <th class="px-4 py-3">الغرفة</th>
                        <th class="px-4 py-3">الحالة</th>
                        <th class="px-4 py-3">الوقت</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($StatsWaitingList as $item)
                    <tr class="hover:bg-blue-50 transition-colors patient-row">
                        <td class="px-4 py-4 text-lg font-medium text-gray-900">{{ $item->queue_number }}</td>
                        <td class="px-4 py-4">{{ $item->doctor?->name ?? 'عام' }}</td>
                        <td class="px-4 py-4">{{ $item->room?->room_number ?? 'غير محدد' }}</td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($item->status == 'waiting') bg-yellow text-yellow
                                    @elseif($item->status == 'in_progress') bg-blue text-blue
                                    @elseif($item->status == 'completed') bg-green text-green
                                    @else bg-red text-red @endif">
                                {{ match($item->status) {
                                        'waiting' => 'في الانتظار',
                                        'in_progress' => 'جاري الكشف',
                                        'completed' => 'مكتمل',
                                        'canceled' => 'ملغي',
                                        default => 'غير معروف'
                                    } }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>






















</body>

</html>
