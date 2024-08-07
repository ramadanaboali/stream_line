<?php

namespace App\Repositories\General;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class WalletTransactionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(WalletTransaction::class);
    }

    public function storeTransaction(Array $data){

        DB::beginTransaction();

        try {
            $transaction=WalletTransaction::create($data);
            if($transaction){
                $wallet=Wallet::withTrashed()->findOrFail($transaction->wallet_id);
                if($transaction->type =="credit"){
                    $wallet->balance=$wallet->balance+$transaction->value;
                    $wallet->save();
                }else {
                    $wallet->balance=$wallet->balance-$transaction->value;
                    $wallet->save();
                }
            }else{
                DB::rollback();
                return "error save data";
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


}
