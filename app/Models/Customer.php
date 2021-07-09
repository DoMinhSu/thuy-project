<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Customer extends User
{
    use HasFactory;
    use Notifiable;

    protected $table = "customers";

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone_number'
    ];
    protected $attributes = [
        'name'=>'',
        'email'=>'',
        'password'=>'',
        'address'=>'',
        'phone_number'=>''
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
