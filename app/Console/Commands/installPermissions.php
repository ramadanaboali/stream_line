<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
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
        $arr =[];
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
                            dd($group);
                            $arr[] =[
                                'name' => $permission[1],
                                'display_name_en' => $permission[1],
                                'display_name_ar' => $permission[1],
                                'model_typ' => $permission[1],
                                'group' => $group[0] ?? null,
                                'guard_name' => 'web',
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

    private function installStaticPermissions(): void
    {
        if (file_exists(base_path('/static_permissions.json'))) {
            $internalPermissions = file_get_contents(base_path('/static_permissions.json'));
            $internalPermissions = json_decode((string) $internalPermissions);

            foreach ($internalPermissions as $permission) {
                $web = Permission::where('name', $permission)->where('guard_name', 'web')->first();
                if ($web == null) {
                    Permission::create(['name' => $permission, 'guard_name' => 'web']);
                }
            }
            $this->info('Static Permissions Installed');
        }
    }

    private function assignPermissionsToAdmin(): void
    {
        $users = User::where('email', 'admin@admin.com')->orWhere('email', 'support@admin.com')->get();
        $role = Role::where('name', 'admin')->first();
        foreach($users as $user) {

            if ($user && $role) {
                $role->syncPermissions(Permission::all());
                $user->syncRoles($role->id);
                Artisan::call('cache:clear');
                $this->info("All Permissions assigned to user {$user->email}");
            }
        }
    }
}
