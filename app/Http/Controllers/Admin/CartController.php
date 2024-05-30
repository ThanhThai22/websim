<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Services\CartService;

class CartController extends Controller
{

    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        return view('admin.carts.customer', [
            'title' => 'Danh sách đơn đặt hàng',
            'customers' => $this->cart->getCustomer()
        ]);
    }
}
