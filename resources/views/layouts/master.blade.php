<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authors')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-light">

<div class="container">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary mb-4">
        @if(Session::has('access_token'))
        <a class="navbar-brand text-white" href="#">Author Management</a>

            @endif
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if(Session::has('access_token'))
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('author.create') }}">Add Author</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('authors.index') }}" class="nav-link text-white">View Authors</a>
                </li>


                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link text-white nav-link">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="mb-4">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
