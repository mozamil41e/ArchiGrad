<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // تنظيف الكاش الخاص بالصلاحيات
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | إنشاء الصلاحيات
        |--------------------------------------------------------------------------
        */

        $modules = [

            'users' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'project' => [
                'view',
                'create',
                'update',
                'delete',
                'archive',
            ],
            'department' => [
                'view',
                'create',
                'update',
                'delete',
            ],
            'supervisor' => [
                'view',
                'create',
                'update',
                'delete',
            ]
        ];

        foreach ($modules as $module => $actions) {

            foreach ($actions as $action) {

                Permission::firstOrCreate([
                    'name' => "{$module}.{$action}",
                    'guard_name' => 'web',
                ]);

            }
        }

        /*
        |--------------------------------------------------------------------------
        | إنشاء الأدوار
        |--------------------------------------------------------------------------
        */

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $user1 = Role::firstOrCreate([
            'name' => 'user1',
            'guard_name' => 'web',
        ]);


        /*
        |--------------------------------------------------------------------------
        | المدير
        |--------------------------------------------------------------------------
        */

        $admin->syncPermissions(
            Permission::all()
        );

        /*
        |--------------------------------------------------------------------------
        | مدير الفرع
        |--------------------------------------------------------------------------
        */

        $user1->syncPermissions([
            'project.view',
            'department.view',
            'supervisor.view',
        ]);


    }
}
