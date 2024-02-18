<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Validate;

class BooksController extends Controller
{
    public function all()
    {
        $books = Book::all();

        if (!empty($books)) {
            return response()->json([
                'status' => 200,
                'message' => 'successfully',
                'data' => $books,
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => "Not Found",
        ], 404);
    }
    
    public function search(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 404,
                'message' => "please enter a value",
            ], 404);
        }

        $booksSearch = Book::where('title', 'like', '%' . request()->title . '%')->get();

        if ($booksSearch) {
            return response()->json([
                'status' => 200,
                'message' => 'successfully',
                'data' => $booksSearch,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Not Found",
            ], 404);
        }
    }
    public function categories()
    {
        $categories = Category::with('books')->get();

        if (!empty($categories)) {
            return response()->json([
                'status' => 200,
                'message' => 'successfully',
                'data' => $categories,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Not Found",
            ], 404);
        }
    }
}
