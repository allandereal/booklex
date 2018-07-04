<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//List books
Route::get('books', 'BooksController@index');
//List single Book
Route::get('book/{id}', 'BooksController@show');
//Create new book
Route::post('book', 'BooksController@store');
//Update book
Route::put('book/{id}', 'BooksController@store');
//Delete book
Route::delete('book/{id}', 'BooksController@delete');
//Search book title
Route::get('books/search/{q}', 'BooksController@search');

//List authors
Route::get('authors', 'AuthorsController@index');
//List single author
Route::get('author/{id}', 'AuthorsController@show');
//Create new author
Route::post('author', 'AuthorsController@store');
//Update author
Route::put('author/{id}', 'AuthorsController@store');
//Delete author
Route::delete('author/{id}', 'AuthorsController@delete');
//Search author name
Route::get('authors/search/{q}', 'AuthorsController@search');