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



// git status
// git add .

// git commit -m "اضافه مشتريات ومبيعات وفواتير والعهد"
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

