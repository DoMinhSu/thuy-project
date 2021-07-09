<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $table;
    protected $model;

    public abstract function model();
    public abstract function table();

    public function index()
    {
        $data = $this->model()::latest()->paginate(10);
        // $categories = Category::all();
        return view('admin.'.$this->table().'.index', compact('data'))->with('table',$this->table());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.'.$this->table().'.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array_merge(request()->all(), ['slug' => request('name')]);
        $category = $this->model()::create($data);
        return redirect()->route('admin.'.$this->table().'.index');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $model = $this->model()::findOrFail(request('_id'));
        $data = array_merge(request()->all(), ['slug' => request('name')]);
        $category = $model->update($data);
        return redirect()->route('admin.'.$this->table().'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $model = $this->model()::findOrFail($id);
        $model->delete();
        return back();
    }
}
