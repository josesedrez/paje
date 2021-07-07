<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryValidation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategories() {
        return Category::orderBy('name')->get();
    }

    public function addNewCategory(Request $request) {
        return Category::create([
            'name' => $request['category']
        ]);
    }

    public function editCategory(Request $request) {
        try {
            $category = Category::find($request['category']);
            $category->name = $request['newName'];
            $category->save();

            return $category;
        } catch (\Exception $exception) {
            return 'failed';
        }
    }

    public function deleteCategory(Request $request) {
        $category = Category::find($request['category']);
        $category->delete();

        return 'deleted';
    }
}
