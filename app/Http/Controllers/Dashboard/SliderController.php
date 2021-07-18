<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    // ======== update images =======
    public function addImages()
    {
        $images = Slider::get(['photo']);
        return view('dashboard.sliders.create', compact('images'));
    }


    // save image in folder only
    public function saveSliderImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = saveImage($file, 'images\sliders');

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function saveSliderImagesDB(SliderRequest $request)
    {
        try {
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Slider::create([
                        'photo' => $image,
                    ]);
                }
            }
            return redirect()->route('admin.sliders.create')->with(['success' => 'تم اضافة صور السلايدر  بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.sliders.create')->with(['error' => 'فشل اضافة الصور']);
        }
    }
}
