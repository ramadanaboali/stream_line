<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;

class installPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command Custom for install permissions for application that used spatie\laravel-permessions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->installRoutesPermissions();
        $this->assignPermissionsToAdmin();

        return 0;
    }

    private function installRoutesPermissions(): void
    {
        $permissions = Permission::where('guard_name', 'api')->get()->pluck('name')->toArray();
        $routes = Route::getRoutes();
        $arr = [];
        $tempPermissions = [];
        foreach ($routes as $route) {
            $middleware = $route->middleware();
            if (is_array($middleware)) {
                foreach ($middleware as $middleware) {
                    if (strpos($middleware, 'adminPermission:') > -1) {
                        $permission = explode(':', $middleware);
                        if (!in_array($permission[1], $tempPermissions) && !in_array($permission[1], $permissions)) {
                            array_push($tempPermissions, $permission[1]);
                            $group = explode('.', $permission[1]);
                            $arr[] = [
                                'name' => $permission[1],
                                'model_type' => 'admin',
                                'group' => $group[0] ?? null,
                                'guard_name' => 'api',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                    if (strpos($middleware, 'vendorPermission:') > -1) {
                        $permission = explode(':', $middleware);
                        if (!in_array($permission[1], $tempPermissions) && !in_array($permission[1], $permissions)) {
                            array_push($tempPermissions, $permission[1]);
                            $group = explode('.', $permission[1]);
                            $arr[] = [
                                'name' => $permission[1],
                                'model_type' => 'vendor',
                                'group' => $group[0] ?? null,
                                'guard_name' => 'api',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                    if (strpos($middleware, 'generalPermission:') > -1) {
                        $permission = explode(':', $middleware);
                        if (!in_array($permission[1], $tempPermissions) && !in_array($permission[1], $permissions)) {
                            array_push($tempPermissions, $permission[1]);
                            $group = explode('.', $permission[1]);
                            $arr[] = [
                                'name' => $permission[1],
                                'model_type' => 'general',
                                'group' => $group[0] ?? null,
                                'guard_name' => 'api',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                }
            }
        }
        if (count($arr) > 0) {
            Permission::insert($arr);
            $this->info('Routes Permissions installed');
        }
    }



    private function assignPermissionsToAdmin(): void
    {
        $user = User::where('email', config('admin.email'))->first();
        $role = Role::where('name', 'superadmin')->where('model_type', 'admin')->first();
        if(!$role) {
            $role = Role::Create([
                'name' => 'superadmin',
                'model_type' => 'admin',
                'guard_name' => 'api',
                'can_edit' => 0,
                'display_name' => 'سوبر ادمن'
            ]);
        }
        if ($user && $role) {
            $user->syncRoles($role->id);
            $role->syncPermissions(Permission::whereIn('model_type', ['admin','general'])->get());
            Artisan::call('cache:clear');
            $this->info("All Permissions assigned to user {$user->email}");
        }
        $vendorRole = Role::firstOrCreate(['name' => 'admin','model_type' => 'vendor','can_edit' => 0], ['name' => 'admin','model_type' => 'vendor','can_edit' => 0,'guard_name' => 'api','display_name' => ' ادمن']);
        if ($vendorRole) {
            $vendorPermissions = Permission::whereIn('model_type', ['vendor','general'])->get();
            $vendorRole->syncPermissions($vendorPermissions);
        }
    }
}
