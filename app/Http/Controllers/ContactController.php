<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use App\Rules\CustomURL;

class ContactController extends Controller
{
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
