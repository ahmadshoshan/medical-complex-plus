<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use ReflectionClass;
use Spatie\Permission\Models\Permission;

class SyncPermissionsFromPolicies extends Command
{
    protected $signature = 'permission:sync-policies
                            {--fresh : حذف جميع الصلاحيات قبل الإنشاء}
                            {--show : عرض الصلاحيات فقط دون حفظ}';

    protected $description = 'قراءة جميع دوال الـ Policies وإنشاء صلاحيات تلقائيًا';

    public function handle(): int
    {
        $policiesPath = app_path('Policies');
        $files = File::files($policiesPath);

        $methods = [];

        foreach ($files as $file) {
            $className = 'App\\Policies\\' . $file->getFilenameWithoutExtension();

            // تخطي الملفات غير الصالحة
            if (!class_exists($className)) {
                continue;
            }

            $reflection = new ReflectionClass($className);

            // جلب الدوال العامة فقط (التي تمثل الصلاحيات)
            $classMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach ($classMethods as $method) {
                $methodName = $method->getName();

                // تجاهل الدوال الخاصة مثل __construct أو دوال النظام
                if ($methodName[0] !== '_' && !in_array($methodName, ['canAccessFilament', 'getFilamentUrl'])) {
                    $methods[] = $methodName;
                }
            }
        }

        // إزالة التكرار
        $uniqueMethods = array_unique($methods);

        // إذا كان الخيار --show
        if ($this->option('show')) {
            $this->info('الصلاحيات التي سيتم إنشاؤها:');
            foreach ($uniqueMethods as $method) {
                $this->line("- $method");
            }
            return self::SUCCESS;
        }

        // إذا كان الخيار --fresh: حذف الكل
        if ($this->option('fresh')) {
            Permission::query()->delete();
            $this->warn('جميع الصلاحيات تم حذفها.');
        }

        $created = 0;
        $skipped = 0;

        foreach ($uniqueMethods as $method) {
            $permission = Permission::firstOrCreate(['name' => $method]);
            if ($permission->wasRecentlyCreated) {
                $this->info("تم إنشاء الصلاحية: $method");
                $created++;
            } else {
                $skipped++;
            }
        }

        $this->newLine();
        $this->info("✅ اكتمل: $created تم إنشاؤها، $skipped تم تخطيها.");

        // إعادة بناء الكاش (مهم لـ spatie)
        Artisan::call('permission:cache-reset');
        $this->info('تم إعادة تحميل كاش الصلاحيات.');

        return self::SUCCESS;
    }
}
