<?php

namespace App\Http\Controllers\auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FirstloginController extends Controller
{
    /*
     * Ensure the user is signed in to access this page
     */
    public function __construct() {
 
        $this->middleware('auth');
 
    }
    /**
     * Show the form to change the user password.
     */
    public function index(){
        $user = User::where('id',Auth::id())->first();
        return view('auth.firstlogin',compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
 
        $user = User::find(Auth::id());
        $hashedPassword = $user->password;
 
        if (Hash::check($request->old, $hashedPassword)) {
            //Change the password
            $user->fill([
                'password' => bcrypt($request->password),
                'first_login' => '1',
            ])->save();
 
            if(auth()->user()->hasRole('parent')){
                return redirect('/apoderado')->with(['status' => 'Password changed successfully']);
            }
            if(auth()->user()->hasRole('teacher|administrator|superadministrator')){
                return redirect('/admin')->with(['status' => 'Password changed successfully']);
            }
 
            
        }
 
        $request->session()->flash('failure', 'Your password has not been changed.');
 
        return back();
 
 
    }
    public function postExpired(PasswordExpiredRequest $request)
    {
        // Checking current password
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is not correct']);
        }
 
        $request->user()->update([
            'password' => bcrypt($request->password),
            'password_changed_at' => Carbon::now()->toDateTimeString()
        ]);
        return redirect()->back()->with(['status' => 'Password changed successfully']);
    }
}
