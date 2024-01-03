<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect("/login");
        } else{
            $user = Auth::user();
            $categories = Category::all();

            return view('kategori', ['user' => $user->name, 'categories' => $categories]);
        }
    }

    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->nama;
        $category->save();

        return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);

        if($category != null){
            $category->name = $request->nama;
            $category->save();

            return redirect('/kategori')->with('success', 'Kategori berhasil diupdate');
        } else {
            return redirect("/kategori")->with("custom_error", "Kategori gagal diupdate");
        }
    }

    public function delete(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        try {
            $category->delete();
            return redirect('/kategori')->with('success', 'Kategori berhasil didelete');
        } catch (QueryException $e) {
            return redirect("/kategori")->with("custom_error", $e->getMessage());
        }

    }
}
