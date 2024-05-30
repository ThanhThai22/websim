<?php


namespace App\Http\Services\Slide;


use App\Models\Slide;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SlideService
{
    public function insertSlide($request)
    {
        try {
            #$request->except('_token');
            Slide::create($request->input());
            Session::flash('success', 'Thêm Slider mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm slide lỗi');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function get()
    {
        return Slide::orderByDesc('id')->paginate(15);
    }

    public function update($request, $slider)
    {
        try {
            $slider->fill($request->input());
            $slider->save();
            Session::flash('success', 'Cập nhật Slider thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật slider Lỗi');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function destroy($request)
    {
        $slider = Slide::where('id', $request->input('id'))->first();
        if ($slider) {
            $path = str_replace('storage', 'public', $slider->thumb);
            Storage::delete($path);
            $slider->delete();
            Session::flash('success', 'Xóa Slider thành công');
            return true;
        }
        Session::flash('error', 'Xóa Slider không thành công');

        return false;
    }

    public function show()
    {
        return Slide::where('active', 1)->orderByDesc('sort_by')->get();
    }
}
