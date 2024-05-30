<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Slide\SlideService;
use App\Models\Slide;

class SlideController extends Controller
{
    protected $slideService;
    public function __construct(SlideService $slideService)
    {
        $this->slideService = $slideService;
    }
    public function index()
    {
        return view('admin.slide.list',[
            'title' => 'Danh sach slide',
            'sliders' => $this->slideService->get()
        ]);
    }

    public function create()
    {
        return view('admin.slide.add',[
            'title' => 'Tao Slide cho website'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $this->slideService->insertSlide($request);

        return redirect()->back();
    }

    public function show(Slide $slider)
    {
        return view('admin.slide.edit', [
            'title' => 'Chỉnh Sửa Slider',
            'slider' => $slider
        ]);
    }

    public function update(Request $request, Slide $slider)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $result = $this->slideService->update($request, $slider);
        if ($result) {
            return redirect('/admin/sliders/list');
        }

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->slideService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công Slider'
            ]);
        }

        return response()->json([ 'error' => true ]);
    }


}
