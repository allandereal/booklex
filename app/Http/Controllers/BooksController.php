<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::take(10)->get();
        return BookResource::collection($books);
    }

    public function search($q){
        $q = urldecode($q);
        if (stristr($q, ' ')){
            $strings = explode(' ', $q);
            $books = array();
            foreach ($strings as $string){
                $db_books = Book::where('title', 'like', $string.'%')->take(20)->get();
                if (count($db_books) > 0){
                    foreach ($db_books as $db_book){
                        array_push($books, $db_book);
                    }
                }
            }
            if (count($books) > 0){return $books;
                return BookResource::collection($books);
            }
        }else{
            $books = Book::where('title', 'like', $q.'%')->take(20)->get();
            if (count($books) > 0){
                return BookResource::collection($books);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = $request->isMethod('put') ? Book::findOrfail($request->book_id) : new Book;
        $book->id = $request->input('book_id');
        $book->isbn = $request->input('isbn');
        $book->title = $request->input('title');
        $book->authorId = $request->input('authorId');
        $book->publisherId = $request->input('publisherId');
        $book->edition = $request->input('edition');
        $book->yearPublished = $request->input('yearPublished');
        $book->price = $request->input('price');
        $book->createdBy = $request->input('createdBy');

        try{
            if ($book->save()){
                return new BookResource($book);
            }
        }catch (QueryException $e){
            return $e->getMessage();
        }

        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if ($book->delete()){
            return new BookResource($book);
        }
        return null;
    }
}
