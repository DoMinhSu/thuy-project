<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends BaseController
{
    public function model()
    {
        return Customer::class;
    }
    public function table()
    {
        return "customers";
    }

}
