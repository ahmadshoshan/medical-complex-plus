<x-filament-panels::page>

    {{-- ====================================================== --}}
    {{--            1. قسم الترحيب المخصص                       --}}
    {{-- ====================================================== --}}
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <h2 class="text-lg font-semibold leading-6 text-gray-950 dark:text-white">
                مرحباً بك مجدداً، {{ auth()->user()->name }}! 👋
            </h2>
        </div>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            هذه هي لوحة التحكم المخصصة لتطبيقك. يمكنك إضافة أي محتوى تريده هنا، مثل إحصائيات سريعة أو إرشادات للمستخدمين.
        </p>
    </x-filament::section>


    {{-- ====================================================== --}}
    {{--            2. عرض الويدجت (Widgets)                     --}}
    {{-- ====================================================== --}}
    {{-- هذا الجزء يعرض جميع الويدجتس التي عرفتها في كلاس      --}}
    {{-- Dashboard.php.                                       --}}
    {{-- ====================================================== --}}
    {{-- @if ($this->hasWidgets())
        <x-filament-widgets::widgets
            :widgets="$this->getVisibleWidgets()"
            :columns="$this->getColumns()"
        />
    @endif--}}


    {{-- ====================================================== --}}
    {{--            3. قسم الروابط السريعة                       --}}
    {{-- ====================================================== --}}
    <x-filament::section>
        {{-- عنوان القسم --}}
        <x-slot name="heading">
            روابط سريعة
        </x-slot>

        {{-- شبكة لعرض البطاقات --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            {{-- البطاقة الأولى: إدارة المستخدمين --}}
            <x-filament::card
                tag="a"
                href="lll"
                class="flex items-center gap-4 transition hover:bg-gray-50 dark:hover:bg-white/5"
            >
                <x-heroicon-o-users class="h-8 w-8 text-gray-500 dark:text-gray-400" />
                <div>
                    <h3 class="font-semibold text-gray-950 dark:text-white">إدارة المستخدمين</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">عرض وتعديل بيانات المستخدمين.</p>
                </div>
            </x-filament::card>

            {{-- البطاقة الثانية: الإعدادات --}}
            <x-filament::card
                tag="a"
                href="#" {{-- ضع رابط صفحة الإعدادات هنا --}}
                class="flex items-center gap-4 transition hover:bg-gray-50 dark:hover:bg-white/5"
            >
                <x-heroicon-o-cog-6-tooth class="h-8 w-8 text-gray-500 dark:text-gray-400" />
                <div>
                    <h3 class="font-semibold text-gray-950 dark:text-white">الإعدادات العامة</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">تعديل إعدادات التطبيق الرئيسية.</p>
                </div>
            </x-filament::card>

            {{-- البطاقة الثالثة: التوثيق --}}
            <x-filament::card
                tag="a"
                href="#" {{-- ضع رابط صفحة التوثيق هنا --}}
                target="_blank"
                class="flex items-center gap-4 transition hover:bg-gray-50 dark:hover:bg-white/5"
            >
                <x-heroicon-o-book-open class="h-8 w-8 text-gray-500 dark:text-gray-400" />
                <div>
                    <h3 class="font-semibold text-gray-950 dark:text-white">التوثيق والمساعدة</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">اطلع على دليل استخدام النظام.</p>
                </div>
            </x-filament::card>

        </div>
    </x-filament::section>

</x-filament-panels::page>
