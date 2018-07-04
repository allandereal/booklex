<?php

namespace App\Http\Controllers;

use App\Author;
use App\Http\Resources\AuthorResource;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::take(10)->get();
        return AuthorResource::collection($authors);
    }

    public function search($q){
        $q = urldecode($q);
        if (stristr($q, ' ')){
            $strings = explode(' ', $q);
            $authors = array();
            foreach ($strings as $string){
                $db_authors = Author::where('title', 'like', $string.'%')->take(20)->get();
                if (count($db_authors) > 0){
                    foreach ($db_authors as $db_author){
                        array_push($authors, $db_author);
                    }
                }
            }
            if (count($authors) > 0){return $authors;
                return AuthorResource::collection($authors);
            }
        }else{
            $authors = Author::where('title', 'like', $q.'%')->take(20)->get();
            if (count($authors) > 0){
                return AuthorResource::collection($authors);
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
        $author = $request->isMethod('put') ? Author::findOrfail($request->author_id) : new Author;
        $author->id = $request->input('named');
        $author->telephone = $request->input('telephone');
        $author->email = $request->input('email');
        $author->qualification = $request->input('qualification');

        try{
            if ($author->save()){
                return new AuthorResource($author);
            }
        }catch (QueryException $e){
            return $e->getCode();
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
        $author = Author::findOrFail($id);
        return new AuthorResource($author);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        if ($author->delete()){
            return new AuthorResource($author);
        }
        return null;
    }
}
