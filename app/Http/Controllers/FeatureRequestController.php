<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeaturesRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\CustomURL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Mail\FeatureRequestMail;


class FeatureRequestController extends Controller
{
    public function store(Request $request){
        $data = $request->all();
        if(!isset($data["ideaName"])){
            $data["ideaName"] = Auth::user()->name;
        }

        if(!isset($data["ideaEmail"])){
            $data["ideaEmail"] = Auth::user()->email;
        }
        
        if(!isset($data["ideaImportance"])){
            $data["ideaImportance"] = "NA";
        }

        //Validate form
        $validator = \Validator::make($data,[
            'ideaName'=>'required',
            'ideaEmail'=>'required',
            'ideaMessage'=> ['required', 'max:300'],
        ],[
            'ideaName.required'=>'Name is required',
            'ideaEmail.required'=>'Email is required',
            'ideaMessage.required'=>'Message is required',
            'ideaMessage.max'=>'Message is too long, please attach a PDF for reference.',
        ]);
        
        $validator->sometimes('ideaUrl', [new CustomURL], function ($input) {
            return $input->ideaUrl != "";
        });


        if(!$validator->passes()){
            return response()->json(['status'=>0,'msg'=>$validator->errors()->toArray()]);
        }else{

            if($request->file('ideaAttachment')){
                $file = $request->file('ideaAttachment');
                $filename = uniqid() . "." . basename($file->getClientOriginalExtension());
                $path = base_path() . "/public/storage/uploads/" . $filename;
                Storage::disk('project')->put('uploads/' . $filename, file_get_contents($file));
            }else{
                $filename = "";
                $path = "";
            }


            $feature = new FeaturesRequest();
            $feature->user_id = Auth::id();
            $feature->name = $data['ideaName'];
            $feature->email = $data['ideaEmail'];
            $feature->url = $request->input('ideaUrl');
            $feature->message = $request->input('ideaMessage');
            $feature->file = $path;
            $feature->importance = $data['ideaImportance'];

            // sending email
            $data["name"] = $data['ideaName'];
            $data["email"] = $data['ideaEmail'];
            $data["url"] = $request->input('ideaUrl');
            $data["message"] = $request->input('ideaMessage');
            $data["file"] = $path;
            $data["importance"] = $data['ideaImportance'];

            $data["subject"] = "Features Request";
            $emails = $request->emails;
            \Mail::to("amit@gmail.com")->send(new FeatureRequestMail($data));

            $store = $feature->save();

            if(!$store){
                return response()->json(['status'=>3,'msg'=>'Something went wrong, Please try again later.']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Feature request sent successfully.']);
            }
        }
    }
}
