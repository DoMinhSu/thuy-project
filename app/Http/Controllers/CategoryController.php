<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function model()
    {
        return Category::class;
    }
    public function table()
    {
        return "categories";
    }


}
