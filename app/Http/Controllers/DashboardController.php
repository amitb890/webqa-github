<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UrlsList;

class DashboardController extends Controller
{
    public function getUrlsList($id){
        $urls = UrlsList::where("projects_id", $id)->get();
        return response()->json( $urls );
    }
}
