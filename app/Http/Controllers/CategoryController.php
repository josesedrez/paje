<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryValidation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryValidation $request)
    {
        Category::create([
            'name' => $request->name
        ]);

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryValidation $request, Category $category)
    {
        $category->update([
            'name' => $request->name
        ]);

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }

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
