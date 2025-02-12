@extends('layouts.master')

@section('title', 'Add New Book')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Add New Book</h1>

            <form action="{{ route('book.store') }}" method="POST">
                @csrf
                <input type="hidden" name="author_id" value="{{$author_id}}">

                <div class="mb-3">
                    <label for="title" class="form-label">Book Title:</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter the book title" value="{{ old('title') }}">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="release_date" class="form-label">Release Date:</label>
                    <input type="date" name="release_date" id="release_date" class="form-control @error('release_date') is-invalid @enderror"
                           value="{{ old('release_date') }}">
                    @error('release_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                              placeholder="Enter a brief description of the book">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN:</label>
                    <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror"
                           placeholder="Enter the ISBN" value="{{ old('isbn') }}">
                    @error('isbn')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="format" class="form-label">Format:</label>
                    <input type="text" name="format" id="format" class="form-control @error('format') is-invalid @enderror"
                           placeholder="Enter the format (e.g., Hardcover, Paperback)" value="{{ old('format') }}">
                    @error('format')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="number_of_pages" class="form-label">Number of Pages:</label>
                    <input type="number" name="number_of_pages" id="number_of_pages" class="form-control @error('number_of_pages') is-invalid @enderror"
                           placeholder="Enter the total number of pages" value="{{ old('number_of_pages') }}">
                    @error('number_of_pages')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Add Book</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('authors.index') }}" class="btn btn-link">Back to Author List</a>
            </div>
        </div>
    </div>
@endsection
