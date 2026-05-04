<?php

namespace App\Http\Controllers;

use App\Mail\PasswordUpdatedMail;
use App\Support\UserDisplayName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\DeletedFeedback;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view("user.profile.index", compact("user"));
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->type === "password"){
            //Validate form
            $validator = \Validator::make($request->all(),[
                'current_password'=>[
                    'required', function($attribute, $value, $fail){
                        if( !\Hash::check($value, Auth::user()->password) ){
                            return $fail(__('The current password is incorrect'));
                        }
                    },
                ],
                'new_password'=>'required',
                'c_new_password'=>'required|same:new_password'
            ],[
                'current_password.required'=>'Enter your current password',
                'new_password.required'=>'Enter new password',
                'c_new_password.required'=>'Re-enter your new password',
                'c_new_password.same'=>'New password and Confirm new password must match'
            ]);

            $validator->sometimes('new_password', function($attribute, $value, $fail) use($request){
                if( $value === $request["current_password"] ){
                    return $fail(__('New password can not be the same as current password'));
                }
            }, function ($input) {
                return true;
            });

            if( !$validator->passes() ){
                return response()->json(['status'=>0,'msg'=>$validator->errors()->toArray()]);
            }else{
                $update = Auth::user()->update(['password'=>\Hash::make($request->new_password)]);
                if(!$update ){
                    return response()->json(['status'=>3,'msg'=>'Something went wrong, Please try again later.']);
                }else{
                    try {
                        Mail::to(Auth::user()->email)->send(new PasswordUpdatedMail(
                            UserDisplayName::firstName(Auth::user()->name)
                        ));
                    } catch (\Throwable $e) {
                        Log::warning('Password updated email failed (profile): '.$e->getMessage(), [
                            'user_id' => Auth::id(),
                        ]);
                    }

                    return response()->json(['status'=>1,'msg'=>'Your password has been updated successfully']);
                }
            }
        }else{
            //Validate form
            $validator = \Validator::make($request->all(),[
                'name'=>'required',
            ],[
                'name.required'=>'Name is required',
            ]);
            if( !$validator->passes() ){
                return response()->json(['status'=>0,'msg'=>$validator->errors()->toArray()]);
            }else{
                $update = Auth::user()->update(['name'=>$request->name]);
                if(!$update){
                    return response()->json(['status'=>3,'msg'=>'Something went wrong, Please try again later.']);
                }else{
                    return response()->json(['status'=>1,'msg'=>'Your name has been updated successfully']);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $validator = \Validator::make($request->all(),[
         ],[
         ]);

        if( !$validator->passes() ){
            return response()->json(['status'=>0,'msg'=>$validator->errors()->toArray()]);
        }else{
            $feedback = new DeletedFeedback();
            $feedback->user_id = Auth::id();
            $feedback->reason = $request->input('reason');
            $feedback->message = $request->input('message');
            $feedbackState = $feedback->save();
            $user = Auth::user();
            $userState = $user->delete();
            if($feedbackState && $userState){
                $successMessage = "Your account has been successfully deleted. We are sorry to see you leave. In case you want to re-instate your account please get in touch at <a href='mailto:support@webqa.co'>support@webqa.co</a>";
                session()->flash('alert-class', 'alert-success alert-success-custom');
                session()->flash('message', $successMessage);
            }else{
                return response()->json(['status'=>0,'msg'=>'There was an error while deleting your account, Please try again later.']);
            }
        }
    }
}
