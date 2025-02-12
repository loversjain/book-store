@extends('layouts.master')

@section('title', 'Create Author')

@section('content')
    <h1 class="text-center mb-4">Create Author</h1>

    <!-- Success or Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Author Creation Form -->
    <form method="POST" action="{{ route('author.store') }}">
        @csrf

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control" >
            @error('first_name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control" >
            @error('last_name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="birthday" class="form-label">Birthday</label>
            <input type="date" id="birthday" name="birthday" value="{{ old('birthday') }}" class="form-control" >
            @error('birthday') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="biography" class="form-label">Biography</label>
            <textarea id="biography" name="biography" class="form-control" >{{ old('biography') }}</textarea>
            @error('biography') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" id="gender" class="form-select" >
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            @error('gender') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="place_of_birth" class="form-label">Place of Birth</label>
            <input type="text" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}" class="form-control" >
            @error('place_of_birth') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Create Author</button>
        </div>
    </form>
@endsection
