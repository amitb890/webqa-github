<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportSettings;
use Helper;

class ReportSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        $settings = ReportSettings::where("user_id", $user->id)->orderBy('id', 'DESC')->get()->first();
        return view("user.report-settings.index", compact("user", "settings"));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Get or create report settings for user
        $reportSettings = ReportSettings::where("user_id", $user->id)->orderBy('id', 'DESC')->get()->first();
        
        if (!$reportSettings) {
            // Create default report settings for user
            $reportSettings = ReportSettings::create([
                'user_id' => $user->id,
                'type' => 'user'
            ]);
        }
        
        // Update all settings directly on the main table
        $reportSettings->update($request->except(['_token', '_method']));

        if($reportSettings){
            return response()->json(['status'=>1,'msg'=>'Report settings updated successfully']);
        }else{
            return response()->json(['status'=>0,'msg'=>'There was an error while updating report settings, please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
