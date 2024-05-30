<?php


namespace App\Http\Services;

use App\Models\Customer;


class CartService
{
    public function getCustomer()
    {
        return Customer::orderByDesc('id')->paginate(15);
    }
}
