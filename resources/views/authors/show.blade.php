@extends('layouts.master')

@section('title', $author['first_name'] . ' ' . $author['last_name'])

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <!-- Author's Profile Section -->
                <div class="card shadow-lg rounded p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/user.png') }}" alt="Profile Picture" class="img-fluid rounded-circle border border-4 border-primary" width="150">
                    </div>

                    <h1 class="text-center mb-4 text-primary">{{ $author['first_name'] }} {{ $author['last_name'] }}</h1>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Birthday:</strong> {{ \Carbon\Carbon::parse($author['birthday'])->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Gender:</strong> {{ ucfirst($author['gender']) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Place of Birth:</strong> {{ $author['place_of_birth'] }}</p>
                        </div>
                    </div>

                    <!-- Books Section with Table -->
                    <h2 class="mt-4 d-flex justify-content-between align-items-center">
                        <span>Books:</span>
                        <a href="{{ route('book.create', ['author_id' => $author['id']]) }}" class="btn btn-primary btn-lg d-flex align-items-center shadow-lg rounded-pill px-4 py-2" style="font-size: 1.1rem; transition: all 0.3s;">
                            <i class="fas fa-plus-circle mr-2"></i> Add Book
                        </a>
                    </h2>

                @if(isset($author['books']) && count($author['books']) > 0)
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($author['books'] as $book)
                                <tr>
                                    <td>{{ $book['title'] }}</td>
                                    <td class="text-center">
                                        <!-- Button to trigger modal -->
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal_{{ $book['id'] }}"
                                            data-action-url="{{ route('book.delete', $book['id']) }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                        </table>
                    @else
                        <p class="text-muted mt-2">No books found for this author.</p>
                    @endif

                    <div class="mt-4 text-center">
                        <a href="{{ route('authors.index') }}" class="btn btn-outline-primary btn-lg">Back to Authors List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($author['books'] as $book)
        <!-- Modal for Deleting the Book -->
        <x-delete-confirmation-modal
            id="deleteModal_{{ $book['id'] }}"
            title="Confirm Deletion"
            message="Are you sure you want to delete this book?"
            :actionUrl="route('book.delete', $book['id'])" />
    @endforeach

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteModal = document.getElementById('deleteModal');

        deleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var actionUrl = button.getAttribute('data-action-url');
            var form = deleteModal.querySelector('form');
            form.setAttribute('action', actionUrl);
        });
    });

</script>

