<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(PAGINATE_COUNT);
        return view('dashboard.tags.index', compact('tags'));
    }


    public function create()
    {
        return view('dashboard.tags.create');
    }

    public function store(TagRequest $request)
    {
        try {
            DB::beginTransaction();
            $tag = Tag::create($request->except('_token'));
            $tag->name = $request->name;
            $tag->save();


            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تمت اضافة العلامة tag بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error' => 'فشل الاضافة']);
        }
    }


    public function edit($tag_id)
    {
        $tag = Tag::find($tag_id);
        if (!$tag) {
            return redirect()->route('admin.tags')->with(['error' => ' العلامة tag غير موجودة']);
        }

        $tag = Tag::get()->find($tag_id);
        return view('dashboard.tags.edit', compact('tag'));
    }

    public function update($tag_id, TagRequest $request)
    {
        try {
            $tag = Tag::find($tag_id);


            if (!$tag) {
                return redirect()->route('admin.categories')->with(['error' => ' العلامة tag غير موجودة']);
            }

            DB::beginTransaction();
            $tag->update($request->except(['id', '_token']));
            $tag->name = $request->name;
            $tag->save();

            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم تحديث العلامة tag بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error' => 'فشل التحديث']);
        }
    }

    public function delete($tag_id)
    {
        try {

            $tag = Tag::find($tag_id);

            if (!$tag) {
                return redirect()->route('admin.tags')->with(['error' => ' العلامة tag غير موجودة']);
            }

            $tag->delete();

            return redirect()->route('admin.tags')->with(['success' => 'تم حذف العلامة tag بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' => 'فشل الحذف']);
        }
    }
}
