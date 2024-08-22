<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;

class addWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:wallets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command Custom for add:wallets for users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->addWallets();
        return 0;
    }

    private function addWallets(): void
    {
        $users=User::all();
        foreach ($users as $user) {
            Wallet::firstOrCreate(
                ['user_id' => $user->id],
                [
                 'balance' => 0,
                'is_active' => "1",
                ]
            );
        }
    }
}
