<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public function account (){
        return $this -> belongsTo (Account::class);
    }

    public function payment () {
        return $this -> hasOne(Payment::class);
    }

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'iban',
        'balance',
        'maintenance_price',
    ];


}
