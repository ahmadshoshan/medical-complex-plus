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
        
        // 1. التحميل المسبق للجرس (مهم جداً لمنع تأخير الشبكة)
        const bellSound = new Audio('/sounds/alert.wav');
        bellSound.preload = 'auto'; // إجبار المتصفح على تحميله في الخلفية فوراً

        // دالة لجلب الأصوات المتاحة
        function loadVoices() {
            voices = window.speechSynthesis.getVoices();
        }
        if (window.speechSynthesis.onvoiceschanged !== undefined) {
            window.speechSynthesis.onvoiceschanged = loadVoices;
        }
        loadVoices();

        // الاستماع لقناة الانتظار
        window.Echo.channel('waiting-room')
            .listen('CallPatient', (e) => {
                console.time('⏱️ زمن الاستجابة الكلي'); // لقياس التأخير بدقة
                
                const message = `الحالة رقم ${e.patientNumber} تتوجه إلى عيادة رقم ${e.roomNumber}`;

                // 2. تشغيل الجرس فوراً (لأنه محمّل مسبقاً)
                bellSound.currentTime = 0; // إعادة الشريط للصفر لضمان التشغيل الفوري
                bellSound.play().catch(err => console.warn("⚠️ تعذر تشغيل الجرس:", err));

                // 3. بدء النطق بعد تأخير ثابت قصير جداً (أكثر موثوقية من onended)
                // 800 مللي ثانية تكفي لسماع الجرس بوضوح دون انتظار طوله الفعلي
                setTimeout(() => {
                    speakOffline(message);
                    console.timeEnd('⏱️ زمن الاستجابة الكلي');
                }, 800); 
            });

        // ==========================================
        // دالة النطق المُحسّنة
        // ==========================================
        function speakOffline(text) {
            // إلغاء أي نطق سابق فوراً
            window.speechSynthesis.cancel();

            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'ar-SA';
            utterance.rate = 0.95; // سرعة متوازنة (أبطأ قليلاً للوضوح)
            utterance.pitch = 1;
            utterance.volume = 1;

            // البحث الذكي عن أفضل صوت عربي
            const arabicVoice = voices.find(v =>
                v.lang.includes('ar') && (
                    v.name.includes('Microsoft') || // تفضيل أصوات مايكروسوفت الحديثة
                    v.name.includes('Google') ||
                    v.name.includes('Hoda') ||
                    v.name.includes('Maged')
                )
            ) || voices.find(v => v.lang.includes('ar')); // Fallback لأي صوت عربي

            if (arabicVoice) {
                utterance.voice = arabicVoice;
            }

            window.speechSynthesis.speak(utterance);
        }
    });
</script>