<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public function account (){
        return $this -> belongsTo (Account::class);
    }

    public function loan (){
        return $this -> belongsTo (Loan::class);
    }

    protected $fillable = [
        'account_id',
        'loan_id',
        'concept',
        'paid_money',
    ];
}
