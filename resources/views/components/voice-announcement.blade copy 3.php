<div style="
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: olivedrab;
        box-shadow: 0 -2px 5px rgba(0,0,0,0.1);

        z-index: 9999;
        height: 30px;

    ">
    @livewire(App\Filament\Widgets\DoctorAppointmentsWidget::class)
</div>



<!-- <style>
        header.fi-topbar {
            display: none !important; /* 🚫 إخفاء الـ topbar */
        }
    </style> -->
<!--
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.location.href.includes("/tv")) {
            let topbar = document.querySelector(".fi-topbar");
            if (topbar) {
                topbar.style.display = "none";
            }
        }
    });
</script> -->
<!-- @push('styles')
<style>
    body[data-route="filament.pages.tv"] .fi-topbar {
        display: none !important;
    }
</style>
@endpush -->



<script>
    window.onload = function() {
        // حدد منتصف الشاشة
        const x = window.innerWidth / 2;
        const y = window.innerHeight / 2;

        // اعمل Click event صناعي
        const ev = new MouseEvent("click", {
            bubbles: true,
            cancelable: true,
            clientX: x,
            clientY: y
        });

        document.body.dispatchEvent(ev);
    };
</script>






<div id="voice-activation-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); color: white; display: flex; flex-direction: column; justify-content: center; align-items: center; z-index: 9999; font-family: Arial, sans-serif; text-align: center; cursor: pointer;">
    <h1 style="font-size: 3rem;">انقر لتفعيل النظام الصوتي</h1>
    <p style="font-size: 1.5rem; margin-top: 20px;">بعد التفعيل، سيتم تشغيل النداءات الصوتية تلقائيًا</p>
</div>

<script>
    document.getElementById('voice-activation-overlay').addEventListener('click', async function activateSpeech() {



        ////////////////////////////////////////////////////////////////////////////////


        const docEl = document.documentElement; // أو عنصر معين مثل document.getElementById('app')
        if (docEl.requestFullscreen) {
            try {
                await docEl.requestFullscreen();
                console.log('دخلت Fullscreen');
            } catch (err) {
                console.error('فشل الدخول في Fullscreen:', err);
            }
        } else if (docEl.webkitRequestFullScreen) { // سفاري/قديمة
            docEl.webkitRequestFullScreen();
        } else if (docEl.msRequestFullscreen) { // IE/Edge القديمة
            docEl.msRequestFullscreen();
        }
        ////////////////////////////////////////////////////////////////////////////////



        let topbar = document.querySelector(".fi-topbar");
        if (topbar) {
            topbar.style.display = "none";
        }

        let sidebar = document.querySelector(".fi-sidebar-open");
        if (sidebar) {
            sidebar.classList.remove("fi-sidebar-open");
        }
        let fi_width = document.querySelector(".fi-width-7xl");
        if (fi_width) {
            fi_width.classList.remove("fi-width-7xl");
        }








        // محاولة إنتاج صوت تجريبي
        const utterance = new SpeechSynthesisUtterance('تم تفعيل النظام الصوتي. ');
        utterance.lang = 'ar-SA';
        utterance.rate = 1;
        utterance.pitch = 1;
        utterance.volume = 1;

        window.speechSynthesis.speak(utterance);

        // إخفاء الشاشة
        this.style.display = 'none';

        // إطلاق حدث لتفعيل باقي النظام
        document.dispatchEvent(new CustomEvent('voiceActivated'));

        // إزالة المستمع
        this.removeEventListener('click', activateSpeech);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.Echo) {
            console.warn('⚠️ Laravel Echo غير محمّل');
            return;
        }

        let voices = [];

        // دالة لجلب الأصوات المتاحة على الجهاز
        function loadVoices() {
            voices = window.speechSynthesis.getVoices();
        }

        // بعض المتصفحات (مثل Chrome) تحتاج إلى هذا الحدث لتحميل الأصوات
        if (window.speechSynthesis.onvoiceschanged !== undefined) {
            window.speechSynthesis.onvoiceschanged = loadVoices;
        }
        
        // محاولة جلب الأصوات فوراً
        loadVoices();

        // الاستماع لقناة الانتظار
        window.Echo.channel('waiting-room')
            .listen('CallPatient', (e) => {
                console.log('✅ تم استقبال الحدث:', e);

                // تنسيق الرسالة لتكون واضحة
                // const message = `الحالة رقم ${e.patientNumber}، يرجى التوجه إلى عيادة الدكتور ${e.doctorName}، غرفة رقم ${e.roomNumber}`;
                    const message = `الحالة رقم ${e.patientNumber} ${e.doctorName} تتوجه إلى عيادة رقم ${e.roomNumber}`;

                // 1. تشغيل جرس التنبيه (ملف محلي يعمل بدون نت)
                const bellSound = new Audio('/sounds/alert.wav'); 
                bellSound.play().catch(err => console.warn("⚠️ تعذر تشغيل الجرس، تأكد من وجود الملف:", err));

                // 2. عند انتهاء الجرس، ابدأ النطق
                bellSound.onended = () => {
                    speakOffline(message);
                };

                // 3. إعادة النداء بعد 6 ثوانٍ للتأكيد (اختياري)
                setTimeout(() => {
                    speakOffline(message);
                }, 6000);
            });

        // ==========================================
        // دالة النطق التي تعمل 100% بدون إنترنت
        // ==========================================
        function speakOffline(text) {
            // إلغاء أي نطق سابق لتجنب تداخل الأصوات
            window.speechSynthesis.cancel();

            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'ar-SA'; // اللغة العربية
            utterance.rate = 0.9;     // أبطأ قليلاً ليكون النطق أوضح في العيادات
            utterance.pitch = 1;
            utterance.volume = 1;

            // البحث الذكي عن أي صوت عربي مثبت على نظام التشغيل
            const arabicVoice = voices.find(v =>
                v.lang.includes('ar') ||
                v.name.includes('Arabic') ||
                v.name.includes('العربية') ||
                v.name.includes('Hoda') ||       // صوت عربي افتراضي في Windows
                v.name.includes('Maged') ||      // صوت عربي افتراضي في Mac
                v.name.includes('Google العربية')
            );

            if (arabicVoice) {
                utterance.voice = arabicVoice;
                console.log('🔊 تم استخدام الصوت العربي المحلي:', arabicVoice.name);
            } else {
                console.warn('⚠️ لم يتم العثور على صوت عربي مثبت، سيتم استخدام الصوت الافتراضي للنظام.');
            }

            // تشغيل النطق
            window.speechSynthesis.speak(utterance);
        }
    });
</script>