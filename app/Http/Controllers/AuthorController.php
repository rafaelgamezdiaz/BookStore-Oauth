<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Http\Resources\AuthorsResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;


class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return AuthorsResource::collection(Author::all());
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreAuthorRequest $request
     * @return AuthorsResource
     */
    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->toArray());
        $author['message'] = 'Author registered';
        return new AuthorsResource($author);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     */
    public function show(Author $author)
    {
       return new AuthorsResource($author);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateAuthorRequest $request
     * @param Author $author
     * @return AuthorsResource
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->toArray());
        $author['message'] = 'Author updated';
        return new AuthorsResource($author);
    }

    /**
     * Remove the specified resource from storage.

     */
    public function destroy(Author $author)
    {
        $author->delete();
        return response(null, 204);
    }
}
