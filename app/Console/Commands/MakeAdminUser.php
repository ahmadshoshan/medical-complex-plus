<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
// php artisan make:admin

class MakeAdminUser extends Command
{
    protected $signature = 'make:admin
                            {--email=admin@admin.com : البريد الإلكتروني}
                            {--password=123456 : كلمة المرور}';

    protected $description = 'إنشاء يوزر admin وإعطائه كل الصلاحيات';

    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');

        // 1. إنشاء المستخدم (لو مش موجود)
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make($password),
            ]
        );

        // 2. إنشاء دور admin (لو مش موجود)
        $role = Role::firstOrCreate(['name' => 'admin']);

        // 3. جلب كل الصلاحيات
        $permissions = Permission::all();

        if ($permissions->count() === 0) {
            $this->warn('⚠️ لا يوجد صلاحيات حالياً، شغّل أوامر المزامنة الأول (مثل filament:sync-role أو permission:sync-policies).');
        }

        // 4. ربط الصلاحيات بالدور
        $role->syncPermissions($permissions);

        // 5. إسناد الدور لليوزر
        $user->assignRole($role);

        $this->info("✅ تم إنشاء المستخدم admin ({$user->email}) وإعطاؤه كل الصلاحيات.");
        return 0;
    }
}


//
// rmdir public\storage
// php artisan storage:link

// php artisan storage:link


// اضغط Win + R واكتب:

// shell:startup
// git clone https://github.com/ahmadshoshan/medical-complex-plus.git
// 0

// composer require milon/barcode
//composer require simplesoftwareio/simple-qrcode

// # 1. تهيئة مجلد Git جديد
// git init

// # 2. إضافة جميع الملفات للتتبع
// git add .

// # 3. عمل أول حفظ (Commit)
// git commit -m "initial commit: نقل المشروع وإعداد Laragon"

// # 4. ربط المشروع بمستودع GitHub الخاص بك (تأكد من صحة الرابط)
// git remote add origin https://github.com/ahmadshoshan/medical-complex-plus.git

// # 5. رفع الملفات إلى GitHub
// git push -u origin main

// git status
// git add .

// git commit -m "اضافه الغنايمة   "
// ارفع التعديلات للـ GitHub:
// git push origin main


// قبل ما تبدأ تشتغل على B، اسحب آخر نسخة:

// git pull origin main



// 2- الاحتفاظ بالملف محليًا فقط (skip worktree)

// لو عايز تخلي الملف موجود في المستودع (repo) لكن عندك محليًا ما يتأثرش بالـ pull:

// git update-index --skip-worktree package.json
// git update-index --skip-worktree composer.json


// 🔁 ولو في أي وقت حبيت ترجع تخليه يتأثر:

// git update-index --no-skip-worktree package.json








// php artisan make:admin
// php artisan permission:sync-policies
// php artisan filament:sync-role
// php artisan filament:userx



// # استبدل الرابط أدناه برابط مستودعك الحقيقي من GitHub
// git remote add origin https://github.com/ahmadshoshan/medical-complex-plus.git

// # التأكد من أن الفرع الرئيسي اسمه main
// git branch -M main

// # رفع الملفات إلى GitHub لأول مرة
// git push -u origin main


// git pull origin main

// git status               # لرؤية الملفات التي تم تعديلها
// git add .                # لإضافة كل التعديلات
// git commit -m "وصف التعديل، مثلاً: إضافة صفحة المشتريات"
// git push origin main     # لرفع التعديلات إلى GitHub