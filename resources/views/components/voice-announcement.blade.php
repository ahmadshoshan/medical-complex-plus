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
    // document.addEventListener('click', function enableSpeech() {
    //         const utterance = new SpeechSynthesisUtterance('تم تفعيل النظام الصوتي');
    //         utterance.lang = 'ar-SA';
    //         window.speechSynthesis.speak(utterance);

    //         // إزالة المستمع بعد التفعيل
    //         document.removeEventListener('click', enableSpeech);
    //     }, { once: true });



    let voices = [];
    let voicesLoaded = false;

    function loadVoices() {
        voices = window.speechSynthesis.getVoices();
        if (voices.length > 0) {
            voicesLoaded = true;
            // console.log('✅ تم تحميل الأصوات:', voices);
            // أوقف إعادة المحاولة
            if (window.voiceInterval) clearInterval(window.voiceInterval);
        }
    }

    window.speechSynthesis.onvoiceschanged = loadVoices;
    loadVoices(); // حاول فورًا

    // كرر المحاولة كل 500 مللي ثانية
    window.voiceInterval = setInterval(loadVoices, 500);

    document.addEventListener('DOMContentLoaded', () => {
        if (!window.Echo) return;

        // تأكد من أن المستخدم تفاعل مع الصفحة (تفعيل الصوت)
        document.addEventListener('click', () => {
            if (!voicesLoaded) loadVoices();
        }, {
            once: true
        });

        window.Echo.channel('waiting-room')
            .listen('CallPatient', (e) => {
                console.log('✅ تم استقبال الحدث:', e);



                // function speakArabic(message) {
                //     const audio = new Audio(`https://translate.google.com/translate_tts?ie=UTF-8&total=1&idx=0&text=${encodeURIComponent(message)}&textlen=32&tl=ar&client=tw-ob`);
                //     audio.play();
                // }

                // // استخدمه بدل speechSynthesis
                // speakArabic('الحالة رقم 5 تتوجه إلى الغرفة رقم 2');




                // تأخير بسيط لضمان جاهزية الأصوات
                setTimeout(() => {

                    const message =
                        `الحالة رقم ${e.patientNumber} ${e.doctorName}
                    تتوجه إلى عيادة رقم ${e.roomNumber}

                    `;
                    const message1 =
                        `الحالة رقم ${e.patientNumber}
                    تتوجه إلى عيادة رقم ${e.roomNumber}
                      عيادة ${e.doctorSpecialty}
                        دكتر${e.doctorName}
                    `;
                    // الطريقة 1: محاولة استخدام Web Speech API
                    if ('speechSynthesis' in window) {
                        const utterance = new SpeechSynthesisUtterance(message);
                        utterance.lang = 'ar-EG';
                        utterance.rate = 1;
                        utterance.pitch = 1;
                        utterance.volume = 1;

                        // ابحث عن صوت عربي
                        const arabicVoice = voices.find(v =>
                            v.lang.includes('ar') ||
                            v.name.includes('Arabic') ||
                            v.name.includes('Google العربية')
                        );

                        if (arabicVoice) {
                            utterance.voice = arabicVoice;
                            console.log('🔊 سيتم استخدام الصوت:', arabicVoice.name);
                            
                        } else {
                            console.warn('⚠️ لم يتم العثور على صوت عربي، سيتم استخدام الصوت الافتراضي');
                        }

                        // تأكد من عدم تشغيل أكثر من صوت
                        if (window.speechSynthesis.speaking) {
                            window.speechSynthesis.cancel();
                        }

                        // window.speechSynthesis.speak(utterance);
                        // بعد انتهاء الصوت الأول، نشغل الصوت الثاني
                        utterance.onend = function() {
                            console.log("✅ انتهى الصوت الأول");

                            if (navigator.onLine) {
                                console.log("🌐 متصل بالإنترنت، تشغيل الصوت الثاني...");
                                const audio = new Audio(
                                    `https://translate.google.com/translate_tts?ie=UTF-8&total=1&idx=0&text=${encodeURIComponent(message)}&textlen=${message.length}&tl=ar&client=tw-ob`
                                );
                                audio.play().catch(err => console.error("⚠️ خطأ في تشغيل الصوت:", err));
                            } else {
                                console.warn("🚫 لا يوجد اتصال بالإنترنت، تم تجاهل تشغيل الصوت الثاني");
                            }
                        };


                        // تشغيل الصوت الأول
                        window.speechSynthesis.speak(utterance);
                    }
                    // الطريقة 2: استخدم Google TTS كنسخة احتياطية
                    else {
                        const audio = new Audio(`https://translate.google.com/translate_tts?ie=UTF-8&total=1&idx=0&text=${encodeURIComponent(message)}&textlen=32&tl=ar&client=tw-ob`);
                        audio.play().catch(err => {
                            console.error('فشل تشغيل الصوت:', err);
                            alert('فشل تشغيل الصوت: ' + message);
                        });
                    }
                }, 500);
            });
    });
</script>
