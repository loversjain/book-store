@extends('layouts.master')

@section('title', 'Login')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Login</h1>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="shadow-sm p-4 rounded bg-white">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Forgot Password Link -->
                        <a href="#" class="text-decoration-none">Forgot your password?</a>
                        <!-- Login Button -->
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
