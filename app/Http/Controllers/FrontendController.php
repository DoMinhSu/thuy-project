<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontendController extends Controller
{
    public function home()
    {
        $query = Product::latest();
        $text = 'All';
        if (request()->has('category')) {
            $text = Category::findOrFail(request('category'))->name;
            $query->whereHas('category', function ($query) use ($text) {
                return $query->where('category_id', request('category'));
            });
        }
        if (request()->has('search')) {
            $text = "Search: " . request('search');
            $query->where('name', "like", "%" . request('search') . "%");
        }
        $products = $query->paginate(12)->withQueryString();

        return view('frontend.index', compact('products', 'text'));
    }
    public function login()
    {
        $login = auth('customers')->attempt(request()->only('email', 'password'));
        if ($login) {
            request()->session()->regenerate();
        }
        return back();
    }
    public function logout()
    {
        auth('customers')->logout();
        request()->session()->invalidate();

        request()->session()->regenerateToken();
        return redirect()->back();
    }
    public function regist()
    {
        $input = [
            'email' => request('email'),
            'password' => Hash::make(request('password'))
        ];
        $customer = Customer::create($input);

        Auth::guard('customers')->login($customer);
        return back();
    }

    public function toInt($int, $delimter = ",", $string = "")
    {
        return intval(str_replace($delimter, $string, $int));
    }

    public function getAuthId()
    {
        return auth('customers')->user()->id;
    }
    public function addToCart()
    {
        $productId = request('productId');
        $quantity = request('quantity');

        $Product = Product::findOrFail($productId);

        \Cart::add(array(
            'id' => $productId,
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => $quantity,
            'product_id' => $productId,
            // 'order_id',
        ));
        return \Cart::getTotalQuantity();
    }
    public function updateAllCart()
    {
        foreach (request()->all() as $cartItem) {
            \Cart::update($cartItem['id'], array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $cartItem['quantity'] ,
                ),
            ));
        }
        return \Cart::getTotalQuantity();
    }
}
