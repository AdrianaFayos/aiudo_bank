<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public function user (){
        return $this -> belongsTo (User::class);
    }

    public function loan () {
        return $this -> hasMany(Loan::class);
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
