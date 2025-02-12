<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('access_token')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}

?>
