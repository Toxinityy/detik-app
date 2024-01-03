<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Category;
use Illuminate\Database\QueryException;

class BookController extends Controller
{

    public function index()
    {
        if(!Auth::check()){
            return redirect("/login");
        } else{
            $user = Auth::user();
            $books = Book::all();
            $categories = Category::all();
            $bookCategories = Book::with('categories')->get();
            return view('daftar_buku', ['user' => $user->name, 'books' => $books, 'categories' => $categories, 'bookCategories' => $bookCategories]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $userId = $request->input('user_id');
        $selectedCategories = $request->input('categories', []);
        // dd($selectedCategories);

        $coverFile = $request->file('cover');
        if ($coverFile->isValid()) {
            $coverPath = $coverFile->move(public_path('images'), $userId . '_cover.jpg');
            $coverFilename = 'images/' . $userId . '_cover.jpg';
        } else {
            return redirect('/buku')->with('error', 'Cover file tidak valid');
        }

        $pdfFile = $request->file('pdf');
        if ($pdfFile->isValid()) {
            $pdfPath = $pdfFile->move(public_path('files'), $userId . '_file.pdf');
            $pdfFilename = 'files/' . $userId . '_file.pdf';
        } else {
            return redirect('/buku')->with('error', 'PDF file tidak valid');
        }

        $book = new Book([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'cover_path' => $coverFilename,
            'file_path' => $pdfFilename,
            'user_id' => $userId,
        ]);
        $book->save();

        $book->categories()->attach($selectedCategories);

        return redirect('/buku')->with('success', 'Book has been added successfully');
    }


    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    public function delete(Request $request)
    {
        $book = Book::where('id', $request->id)->first();
        try {
            $book->delete();
            return redirect('/buku')->with('success', 'Buku berhasil didelete');
        } catch (QueryException $e) {
            return redirect("/buku")->with("custom_error", $e->getMessage());
        }

    }
}
