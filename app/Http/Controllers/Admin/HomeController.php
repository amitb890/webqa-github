<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;


class HomeController extends Controller
{
    
    /**
     * Show the application dashboard (list of all accounts).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::withTrashed()->orderBy('id', 'DESC')->get();

        return view('admin.home', compact('users'));
    }
}