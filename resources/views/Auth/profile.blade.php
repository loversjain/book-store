@extends('layouts.master')

@section('title', 'User Profile')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <!-- Card for User Profile -->
                <div class="card shadow-lg rounded p-4 bg-light">
                    <!-- Profile Picture Section -->
                    <div class="text-center mb-4">
                        <img src="{{asset('img/user.png')}}" alt="Profile Picture" class="img-fluid rounded-circle border border-4 border-info" width="150">
                    </div>

                    <!-- User Information Section -->
                    <h2 class="text-center mb-4 text-primary">{{ $user['first_name'] }} {{ $user['last_name'] }}</h2>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <p id="email" class="form-control-plaintext">{{ $user['email'] }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label fw-bold">Gender</label>
                        <p id="gender" class="form-control-plaintext">{{ ucfirst($user['gender']) }}</p>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
