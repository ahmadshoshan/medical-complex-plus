<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;

class SyncFilamentRole extends Command
{
    protected $signature = 'filament:sync-role
                            {--fresh : حذف جميع الصلاحيات قبل الإنشاء}
                            {--show : عرض فقط دون حفظ}';

    protected $description = 'قراءة جميع Filament Resources وPages وإنشاء صلاحيات تلقائيًا';

    // الأفعال المدعومة
    protected $actions = [
        'view',

    ];

    public function handle()
    {
         if ($this->option('fresh')) {
             Role::query()->delete();
             $this->warn('تم حذف جميع الصلاحيات القديمة.');
         }

        $permissions = ['admin'];

        // 1. اقرأ جميع Resources
   $resourcesPath = app_path('Filament/Resources');
$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($resourcesPath));

$files = [];
foreach ($iterator as $file) {
    if ($file->isDir()) continue;

    $filename = $file->getFilename();

    // نريد فقط الملفات التي تنتهي بـ Resource.php وليست RelationManager
    if (!Str::endsWith($filename, 'Resource.php')) {
        continue;
    }

    if (Str::contains($filename, 'RelationManager')) {
        continue;
    }

    $files[] = $file;
}

foreach ($files as $file) {
    // المسار النسبي من app/
    $relativePath = Str::after($file->getPathname(), app_path() . DIRECTORY_SEPARATOR);
    $relativePath = Str::replace(['/', '.php'], ['\\', ''], $relativePath);

    $className = 'App\\' . $relativePath;

    if (!class_exists($className)) {
        $this->warn("الكلاس غير موجود: $className");
        continue;
    }

    $shortName = class_basename($className);
    $singular = Str::before($shortName, 'Resource');
    $plural = Str::plural(Str::lower($singular));
 $permissions[] = "$plural";

}

        // 2. اقرأ جميع Pages
        $pagesPath = app_path('Filament/Pages');
        if (File::exists($pagesPath)) {
            $files = File::allFiles($pagesPath);
            foreach ($files as $file) {
                $className = 'App\\Filament\\Pages\\' . $file->getRelativePathName();
                $className = Str::replace(['/', '.php'], ['\\', ''], $className);

                if (!class_exists($className)) continue;

                $shortName = class_basename($className);
                $pageName = Str::snake($shortName); // manage_homepage

                $permissions[] = "$pageName";
            }
        }

        // إزالة التكرار
        $uniquePermissions = array_unique($permissions);

        if ($this->option('show')) {
            $this->info('الصلاحيات التي سيتم إنشاؤها:');
            foreach ($uniquePermissions as $perm) {
                $this->line("- $perm");
            }
            return 0;
        }

        $created = 0;
        foreach ($uniquePermissions as $permissionName) {
            $permission = Role::firstOrCreate(['name' => $permissionName]);
            if ($permission->wasRecentlyCreated) {
                $this->info("تم إنشاء الصلاحية: $permissionName");
                $created++;
            }
        }

        $this->newLine();
        $this->info("✅ تم إنشاء $created صلاحية جديدة.");
        $this->comment("إجمالي الصلاحيات: " . count($uniquePermissions));

        // إعادة تحميل الكاش
        Artisan::call('permission:cache-reset');
        $this->info('تم تحديث كاش الصلاحيات.');

        return 0;
    }
}
