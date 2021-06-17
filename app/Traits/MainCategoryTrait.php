<?php

namespace App\Traits;

use App\Models\Category;

trait MainCategoryTrait
{
    public function checkCatExist($main_cat)
    {
        // $category = Category::find($main_cat);

        // if (!$category) {
        //     return redirect()->route('admin.mainCategories')->with(['error' => 'هذا القسم غير موجود']);
        // }
    }

    // public function delete()
    // {
    //     return redirect()->route('admin.mainCategories')->with(['success' => 'تم حذف القسم بنجاح']);
    // }
}
