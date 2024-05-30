<?php

namespace App\Http\Services\Product;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductAdminService
{
    public function getMenu()
    {
        //tra ve gia tri menu noi ma active == 1
        return Menu::where('active', 1)->get();
    }

    protected function isValidPrice($request) //kiem tra gia ca
    {
        if ($request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') >= $request->input('price')
        ) {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc');
            return false;
        }

        if ($request->input('price_sale') != 0 && (int)$request->input('price') == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return false;
        }

        return  true;
    }

    public function insert($request)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice == false)
        {
            return false;
        }
        try
        {
            $request->except('_token'); //kiem token cua san pham
            Product::create($request->all());
            Session::flash('success','Thêm sản phẩm thành công');

        }catch (\Exception $err)
        {
            Session::flash('error',$err->getMessage());
            return false;
        }
        return true;

        // $isValidPrice = $this->isValidPrice($request);
        // if ($isValidPrice === false) return false;

        // try {
        //     $request->except('_token');
        //     Product::create($request->all());

        //     Session::flash('success', 'Thêm Sản phẩm thành công');
        // } catch (\Exception $err) {
        //     Session::flash('error', 'Thêm Sản phẩm lỗi');
        //     \Log::info($err->getMessage());
        //     return  false;
        // }

        // return  true;
    }

    public function get()
    {
        return Product::with('menu')->orderByDesc('id')->paginate(15);
    }

    public function update($request, $product)
    {
        $isValidPrice = $this->isValidPrice($request);

        if($isValidPrice == false) return false;

        try{
            $product->fill($request->input()); //fill toan bo thong tin o trang edit vao day
            $product->save(); //luu lai thong tin da fill
            Session::flash('success', 'Cập nhật sản phẩm thành công!!!');
        }catch(Exception $err){
            Session::flash('error', 'Đã có lỗi xảy ra !!!');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($request)
    {
        $product = Product::where('id', $request->input('id'))->first(); //kiem tra id cua san phma co ton tai khong
        if ($product) {
            $product->delete();
            Session::flash('success', 'Xóa sản phẩm thành công!!!');
            return true;
        }
        Session::flash('error', 'Đã có lỗi xảy ra !!!');
        return false;
    }
}
