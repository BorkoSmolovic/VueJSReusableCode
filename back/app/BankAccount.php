<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = ['account_number', 'bank_id', 'partner_id', 'isActive', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $with = ['bank'];
    protected $casts = ["isActive" => "boolean", 'user_id' => 'integer', 'bank_id' => 'integer', 'partner_id' => 'integer'];

    public function bank(){
        return $this->belongsTo('App\Bank');
    }

    public static function addBankAccount($accountNumber, $bankId, $partnerId, $userId){

        return BankAccount::create([
            'account_number' => $accountNumber,
            'bank_id' => $bankId,
            'partner_id' => $partnerId,
            'isActive' => 1,
            'user_id' => $userId
        ]);
    }

    public static function updateBankAccount($accountNumber, $bankId, $partnerId, $bankAccountId, $userId){

        $bankAccount = BankAccount::find($bankAccountId);
        return $bankAccount->update([
            'account_number' => $accountNumber,
            'bank_id' => $bankId,
            'partner_id' => $partnerId,
            'user_id' => $userId
        ]);
    }
}
