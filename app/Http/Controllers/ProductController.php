<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends BaseController
{
    public function model()
    {
        return Product::class;
    }
    public function table()
    {
        return "products";
    }
    public function index()
    {
        $data = $this->model()::latest()->paginate(10);
        $categories = Category::all();
        return view('admin.' . $this->table() . '.index', compact('data', 'categories'))->with('table', $this->table());
    }
    public function store(Request $request)
    {
        $path = '';
        if ($request->hasFile('image')) {
            $path = request()->file('image')->store("products", "public");
        }
        $data = array_merge(request()->all(), ['image' => $path]);
        $category = $this->model()::create($data);
        return redirect()->route('admin.' . $this->table() . '.index');
    }
    public function update()
    {

        $model = $this->model()::findOrFail(request('_id'));
        if (request()->hasFile('image')) {
            Storage::delete($model->image);
            $path = request()->file('image')->store("products", "public");
        }
        $data = array_merge(request()->all(), ['image' => $path]);
        $category = $model->update($data);
        return redirect()->route('admin.' . $this->table() . '.index');
    }
}
