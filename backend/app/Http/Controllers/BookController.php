<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
// use App\Http\Requests\BookStoreRequest; // Comment this out for testing
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all(); 
          
        // Return Json Response
        return response()->json([
            'results' => $books
        ], 200);
    }
   
    public function store(Request $request) // Use plain Request for testing
    {
        try {
            // Log the request data
            Log::info('Request data: ', $request->all());

            // Validate the request data manually for testing
            $request->validate([
                'title' => 'required|string',
                'author' => 'required|string',
                'year' => 'required|integer'
            ]);

            // Create Book
            $book = Book::create([
                'title' => $request->title,
                'author' => $request->author,
                'year' => $request->year
            ]);

            // Return Json Response
            return response()->json([
                'message' => "Book successfully created.",
                'book' => $book
            ], 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error creating book: ', ['error' => $e->getMessage()]);

            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!",
                'error' => $e->getMessage()
            ], 500);
        }
    }
   
    public function show($id)
    {
        // Book Detail 
        $book = Book::find($id);
        if(!$book){
            return response()->json([
                'message' => 'Book Not Found.'
            ], 404);
        }
       
        // Return Json Response
        return response()->json([
            'book' => $book
        ], 200);
    }
   
    public function update(Request $request, $id)
    {
        try {
            // Find Book
            $book = Book::find($id);
            if(!$book){
                return response()->json([
                    'message' => 'Book Not Found.'
                ], 404);
            }
       
            // Validate the request data manually for testing
            $request->validate([
                'title' => 'required|string',
                'author' => 'required|string',
                'year' => 'required|integer'
            ]);

            // Update Book
            $book->title = $request->title;
            $book->author = $request->author;
            $book->year = $request->year;
            $book->save();
       
            // Return Json Response
            return response()->json([
                'message' => "Book successfully updated.",
                'book' => $book
            ], 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error updating book: ', ['error' => $e->getMessage()]);

            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!",
                'error' => $e->getMessage()
            ], 500);
        }
    }
   
    public function destroy($id)
    {
        // Book Detail 
        $book = Book::find($id);
        if(!$book){
            return response()->json([
                'message' => 'Book Not Found.'
            ], 404);
        }
         
        // Delete Book
        $book->delete();
       
        // Return Json Response
        return response()->json([
            'message' => "Book successfully deleted."
        ], 200);
    }
}
