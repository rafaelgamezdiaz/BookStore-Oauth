<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BooksResource;
use App\Models\Book;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    /**
     * Display a listing of Books
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return BooksResource::collection(Book::all());
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreBookRequest $request
     * @return BooksResource
     */
    public function store(StoreBookRequest $request): BooksResource
    {
        $book = Book::create($request->toArray());
        return new BooksResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return new BooksResource($book);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateBookRequest $request
     * @param Book $book
     * @return BooksResource
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->toArray());
        return new BooksResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response(null, 204);
    }
}
