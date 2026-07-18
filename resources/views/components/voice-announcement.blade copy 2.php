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
                const message = `الحالة رقم ${e.patientNumber}، يرجى التوجه إلى عيادة الدكتور ${e.doctorName}، غرفة رقم ${e.roomNumber}`;

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