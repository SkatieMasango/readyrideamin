<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddedRootWallet extends Command
{
    protected $signature = 'wallet:root-admin';
    protected $description = 'Added admin and root wallets';

    public function handle()
    {
        // Optionally wrap in transaction
        DB::beginTransaction();
        try {

            $rootUser = User::role('root')->first();
            $adminUser = User::role('admin')->first();

             if (!$rootUser || !$adminUser) {
                throw new \Exception('Root or Admin user not found!');
            }

            $this->createWalletIfNotExists($rootUser);
            $this->createWalletIfNotExists($adminUser);

            DB::commit();
            $this->info('Root and Admin wallets have been created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Failed to delete related data: ' . $e->getMessage());
        }
    }

     protected function createWalletIfNotExists(User $user)
    {
        $wallet = Wallet::where('user_id', $user->id)->first();

        if (!$wallet) {
            Wallet::create([
                'user_id' => $user->id,
                'amount' => 0,
            ]);
            $this->info('Wallet created for user: ' . $user->email);
        } else {
            $this->info('Wallet already exists for user: ' . $user->email);
        }
    }
}
