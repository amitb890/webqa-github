<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;

class TrackerController extends Controller
{
    public function index(){
        return view("user.website-tracker.index");
    }

    public function indexTest(){
        return view("user.website-tracker.test");
    }

    public function getData(Request $request){
        $project = Projects::find($id);
        return view("user.website-tracker.index", compact("project"));
    }
}
