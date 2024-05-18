<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Menu\MenuService;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;



class MenuController extends Controller
{

    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        return view('admin.menu.list', [
            'title' => 'Danh Sách Danh Mục mới nhất',
            'menus' => $this->menuService->getAll()
        ]);
    }

    public function create()
    {
        return view('admin.menu.add', [
            'title' => 'Thêm Danh Mục Mới',
            'menus' => $this->menuService->getParent()
        ]);
    }

    public function store(CreateFormRequest $request)
    {
        $this->menuService->create($request);

        return redirect()->back();
    }

    public function destroy(Request $request): JsonResponse
    {
        $result = $this->menuService->destroy($request);

        if($result){
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công'
            ]);
        }
        return \response()->json([
            'error' => true
        ]);
        // $this->menuService->destroy($request);

        // return redirect('/admin/menus/list')->refresh();
    }

    public function show(Menu $menu)
    {
        // dd($menu->name);
        return view('admin.menu.edit', [
            'title' => 'Chỉnh sửa Danh Mục'. $menu->name,
            'menu' => $menu,
            'menus' => $this->menuService->getAll()
        ]);
    }

    public function update(Menu $menu, CreateFormRequest $request){
        $this->menuService->update($request, $menu);
        return redirect('/admin/menus/list');
    }
}
