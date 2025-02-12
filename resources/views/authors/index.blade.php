@extends('layouts.master')

@section('title', 'Authors')

@section('content')
    <h1 class="text-center mb-4">Authors</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Birthday</th>
            <th>Gender</th>
            <th>Place of Birth</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($authors['items'] as $author)
            <tr>
                <td>{{ $author['first_name'] }}</td>
                <td>{{ $author['last_name'] }}</td>
                <td>{{ \Carbon\Carbon::parse($author['birthday'])->format('M d, Y') }}</td>
                <td>{{ ucfirst($author['gender']) }}</td>
                <td>{{ $author['place_of_birth'] }}</td>
                <td>
                    <a href="{{ route('authors.show', $author['id']) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('book.create', ["author_id" =>$author['id']]) }}" class="btn btn-info btn-sm">Add Book</a>

                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                            onclick="setDeleteAction('{{ route('authors.delete', $author['id']) }}')">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Include the Modal Component -->
    <x-delete-confirmation-modal
        id="deleteModal"
        title="Confirm Deletion"
        message="Are you sure you want to delete this author?"
        :actionUrl="route('authors.delete', $author['id'])" />

    <script>
        function setDeleteAction(url) {
            document.getElementById('deleteModal').querySelector('form').action = url;
        }
    </script>
@endsection
