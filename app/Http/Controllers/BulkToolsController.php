<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use App\Rules\CustomURL;
use Helper;

class BulkToolsController extends Controller
{

    public function index(){
        return view("bulk-tools.index")->with("headerPadding", "tools_landing_page");
    }


    public function show($slug){
        $helpers = new Helper();
        $data = $helpers->getAllTests();

        foreach($data["data"] as $d){
            if($slug === $d["slug"]){
                // return view("bulk-tools.show", compact("data", "d", "slug"));
                return view("bulk-tools.show", array_merge(
                    compact("data", "d", "slug"),
                    ["headerPadding" => "tool_pages"]
                ));
            }
        }

        return abort(404);
    }

    public function store(Request $request){
        $data = $request->input('data');
        $validator = \Validator::make($data,[
            'nameContact' => ['required', 'string', 'max:50'],
            'emailContact' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9@]+/u'],
            'websiteAddress'=>['required', new CustomURL],
        ],[
            'nameContact.required'=>'Name is required',
            'emailContact.required'=>'Email is required',
            'websiteAddress.required'=>'Enter your website address',
        ]);

        if( !$validator->passes() ){
            return response()->json(['status'=>0,'msg'=>$validator->errors()->toArray()]);
        }else{
            $data = ([
                "name" => $data["nameContact"],
                "email" => $data["emailContact"],
                "website" => $data["websiteAddress"],
                ]);
            \Mail::to($request->email)->send(new ContactMail($data));
        }
    }
}
