<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
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

    /**
     * Email the user a self-service password reset link.
     */
    public function sendResetEmail($id)
    {
        $user = User::findOrFail($id);

        $status = Password::sendResetLink(['email' => $user->email]);

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->back()->with('success', "Password reset email sent to {$user->email}.");
        }

        return redirect()->back()->with('error', 'Could not send the reset email. Please try again.');
    }

    /**
     * Set a new password for the user directly from the admin panel.
     */
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', "Password updated for {$user->email}.");
    }

    /**
     * Log in as the selected user (impersonation) and open their dashboard.
     *
     * The admin panel uses its own isolated session cookie, so we cannot log
     * into the web guard from here directly (that would write to the admin
     * session, not the user session). Instead we hand off to a short-lived,
     * signed web route that performs the login in the user's session.
     */
    public function launch($id)
    {
        $user = User::findOrFail($id);

        if ($user->deleted_at) {
            return redirect()->back()->with('error', 'Cannot launch a deleted account. Activate it first.');
        }

        $url = URL::temporarySignedRoute('impersonate', now()->addMinutes(2), ['user' => $user->id]);

        return redirect($url);
    }

    /**
     * Signed hand-off target (web session) that actually logs the admin in as
     * the selected user. Reached only via the signed URL from launch().
     */
    public function impersonate(User $user)
    {
        Auth::guard('web')->login($user);

        return redirect('/dashboard');
    }
}
