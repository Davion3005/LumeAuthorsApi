<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return list of authors
     *
     * @return Response
     */
    public function index()
    {
        $authors = Author::all();

        return $this->successResponse($authors);
    }

    /**
     * Create one new authors
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255',
        ];
        $this->validate($request, $rules);
        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Obtains and shows one author
     *
     * @return Response
     */
    public function show($author)
    {
        $author = Author::findOrFail($author);

        return $this->successResponse($author);
    }

    /**
     * Updates an existing author
     *
     * @return Response
     */
    public function update(Request $request, $author)
    {
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
        ];
        $this->validate($request, $rules);
        $author = Author::findOrFail($author);
        $author->fill($request->all());
        if ($author->isClean()) {
            return $this->errorResponse('At least one field must be changed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $author->save();

        return $this->successResponse($author);
    }

    /**
     * Deletes an existing author
     *
     * @return Response
     */
    public function destroy($author)
    {
        $author = Author::findOrFail($author);
        $author->delete();

        return $this->successResponse($author);
    }
}
