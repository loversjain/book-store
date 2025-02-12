<?php

namespace App\Http\Controllers\Web\Book;

use App\Http\Controllers\Controller;
use App\Services\AuthorService;
use App\Services\BookService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * BookController constructor.
     *
     * @param BookService $bookService
     */
    public function __construct( protected BookService $bookService, protected AuthorService $authorService){}

    /**
     * Show the form to create a new book.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateBookForm($author_id)
    {
        return view('books.create', compact('author_id'));
    }
    /**
     * Store a new book in the system.
     *
     * @param StoreBookRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBook(StoreBookRequest $request)
    {
        // Get the author by ID
        $author = $this->authorService->getAuthor($request->author_id);

        // Check if the author exists
        if (!$author) {
            // If the author is not found, return an error message and redirect back
            return back()->with('error', 'Author not found. Please check the author details and try again.');
        }


        // Prepare the book data
        $bookData = [
            'title' => $request->title,
            'author' => ['id' => $request->author_id],
            'release_date' => $request->release_date,
            'description' => $request->description,
            'isbn' => $request->isbn,
            'format' => $request->format,
            'number_of_pages' => $request->number_of_pages,
        ];

        // Send the request to the BookService to create the book
        $response = $this->bookService->storeBook($bookData);

        // Check if the book creation was successful
        if ($response) {
            return redirect()->route('authors.show', ["author_id"=> $request->author_id])->with('success', 'Book added successfully.');
        } else {
            return back()->with('error', 'Failed to add book.');
        }
    }


    /**
     * Delete a book from the system.
     *
     * @param Request $request
     * @param int $book_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteBook(Request $request, $book_id)
    {
        // Send the request to the BookService to delete the book
        $isDeleted = $this->bookService->deleteBook($book_id);

        if ($isDeleted) {
            session()->flash('success', 'Book deleted successfully.');
        } else {
            session()->flash('error', 'Failed to delete book.');
        }

        // Redirect back to the previous page (or wherever you want to show the message)
        return redirect()->back();
    }
}
