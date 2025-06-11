<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\projectSettings;
use App\Models\SettingsSub;

class DataController extends Controller
{
    public function getSettings($id)
    {
        $project = Projects::find($id);
        $settings = projectSettings::where("projects_id", $project->id)->with("settingsSub")->get()->first();
        return response()->json( $settings );
    }
}
