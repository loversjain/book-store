<?php

namespace App\Http\Controllers\Web\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAuthorRequest;
use App\Services\AuthorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{

    /**
     * AuthorController constructor.
     *
     * @param AuthorService $authorService
     */
    public function __construct(protected AuthorService $authorService)
    {}

    /**
     * Show the form to create a new author.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateAuthorForm()
    {
        return view('authors.create');
    }

    /**
     * Fetch a list of authors and display them.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function getAuthors(Request $request)
    {
        $authors = $this->authorService->getAuthors();

        if ($authors === null) {
            return view('authors.index', ['error' => 'Failed to fetch authors']);
        }

        return view('authors.index', ['authors' => $authors]);
    }

    /**
     * Fetch and display a specific author by ID.
     *
     * @param Request $request
     * @param int $author_id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function getAuthor(Request $request, $author_id)
    {
        $author = $this->authorService->getAuthor($author_id);

        if ($author === null) {
            return redirect()->route('authors.index')->with('error', 'Failed to fetch author details');
        }

        return view('authors.show', ['author' => $author]);
    }

    /**
     * Handle the creation of a new author.
     *
     * @param CreateAuthorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAuthor(CreateAuthorRequest $request)
    {

        $authorData = $request->validated();

        $isCreated = $this->authorService->createAuthor($authorData);

        if ($isCreated) {
            return redirect()->route('authors.index')->with('success', 'Author created successfully.');
        }

        return back()->with('error', 'Failed to create author.')->withInput();
    }

    /**
     * Handle the deletion of an author by ID.
     *
     * @param Request $request
     * @param int $author_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAuthor(Request $request, $author_id)
    {
        $isDeleted = $this->authorService->deleteAuthor($author_id);
       if($isDeleted === 'has_books') {
        // Return the error response if there are related books
            return redirect()->route('authors.index')->with('error', 'Cannot delete author, there are related books.');
        }
        if ($isDeleted) {
            return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
        }

        return redirect()->route('authors.index')->with('error', 'Failed to delete author');
    }
}
