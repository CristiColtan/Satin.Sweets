<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::select('id', 'name', 'parent_id')->with('children:id,name,parent_id')->get();
    }

    public function getParentCategories()
    {
        return Category::select('id', 'name', 'parent_id')->whereNull('parent_id')->get();
    }
}
