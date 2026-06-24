<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        if (Auth::guard('admin')->check()) {
            return redirect(RouteServiceProvider::ADMIN);
        }

        return view('admin.auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->adminAuthenticate();
        $request->session()->regenerate();

        return redirect(RouteServiceProvider::ADMIN);
    }

    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}