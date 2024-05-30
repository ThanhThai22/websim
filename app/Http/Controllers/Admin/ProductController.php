<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Product\ProductAdminService;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{

    protected $ProductService;

    public function __construct(ProductAdminService $ProductService)
    {
        $this->ProductService = $ProductService;
    }

    public function index()
    {
        return view('admin.product.list', [
            'title' => 'DANH SÁCH SẢN PHẨM',
            'products' => $this->ProductService->get()
        ]);
    }

    public function create()
    {
        return view('admin.product.add',[
            'title' => 'Trang tạo sản phẩm',
            'menus' => $this->ProductService->getMenu()
        ]);
    }


    public function store(ProductRequest $request)
    {
        $this->ProductService->insert($request);
        return redirect()->back();
    }

    public function edit($id)
    {
        //
    }

    public function show(Product $product)
    {
        return view('admin.product.edit', [
            'title' => 'Chỉnh sửa danh mục sản phẩm',
            'product' => $product,
            'menus' => $this->ProductService->getMenu()
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $result = $this->ProductService->update($request, $product);
        if($result){
            return \redirect('admin/products/list');
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->ProductService->delete($request);

        if($result){
            return response()->json([
                'error' => false,
                'message' => 'Xóa Thành Công Sản Phẩm'
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }
}
