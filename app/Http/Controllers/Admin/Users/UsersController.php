<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function view(){
        $users = User::withTrashed()->orderBy('id', 'DESC')->get();
        return view("admin.users.view", compact("users"));
    }

    public function search(Request $request){
        $keyword = $request->keyword;

        $employees = User::withTrashed()->orderBy('id', 'DESC')->get();
        if($request->keyword != ''){
            $employees = User::withTrashed()->where('email','LIKE','%'.$request->keyword.'%')->orderBy('id', 'DESC')->get();
        }
        return response()->json([
            'employees' => $employees
        ]);
    }

    public function delete($id){
        User::where('id',$id)->delete();
        return redirect()->back()->with("success", "User Deleted Successfully");
    }

    public function activate($id){
        User::withTrashed()->where('id',$id)->restore();
        return redirect()->back()->with("success", "User Activated Successfully");
    }
}
