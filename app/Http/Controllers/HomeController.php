<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth,App\Models\Instrument;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        switch (Auth::user()->user_type) {
            case 1:
                return redirect('admin/dashboard');break;
            case 2:
                return redirect('tutor/dashboard');break;
            case 3:
                return redirect(route('welcome'));break;
                // return redirect('user/dashboard');break;
        }
        return view('home');
    }

    public function logout(Request $request)
    {
        auth()->guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    public function userProfile(Request $req)
    {
        $user = Auth::user();
        $instrument = [];
        if($user->user_type == 2){
            $instrument = Instrument::get();
        }
        return view('auth.user.profile',compact('user','instrument'));
    }

    public function userProfileSave(Request $req)
    {
        $req->validate([
            'name' => 'required|max:200',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'mobile' => 'nullable|numeric',
            'gender' => 'nullable|string|in:Male,Female,Not specified',
            'dob' => 'nullable|date_format:Y-m-d|before:'.date('Y-m-d'),
            'marital' => 'nullable|string|in:Single,Married,Divorced',
            'aniversary' => 'nullable|date_format:Y-m-d|before:'.date('Y-m-d'),
        ]);
        $user = Auth::user();
        $user->name = $req->name;
        $user->email = $req->email;
        if($req->hasFile('image')){
            $image = $req->file('image');
            $user->image = imageUpload($image,'users/image');
        }
        $user->mobile = emptyCheck($req->mobile);
        $user->gender = emptyCheck($req->gender);
        $user->dob = emptyCheck($req->dob,true);
        $user->marital = emptyCheck($req->marital);
        $user->aniversary = emptyCheck($req->aniversary,true);
        if($user->user_type == 2){
            $user->about = emptyCheck($req->about);
            $user->specialist = emptyCheck($req->specialist);
            $user->carrier_started = emptyCheck($req->carrier_started,true);
        }
        $user->save();
        return back()->with('Success','Profile updated successFully');
    }

    public function updateUserPassword(Request $req)
    {
        $req->validate([
            'old_password' => ['required','string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $passwordVerified = false;
        $user = Auth::user();
        if(Hash::check($req->old_password,$user->password)){
            $passwordVerified = true;
        }else{
            $master = Master::first();
            if($master && Hash::check($req->old_password,$master->password)){
                $passwordVerified = true;
            }
        }
        if($passwordVerified){
            $user->password = Hash::make($req->password);
            $user->save();
            return back()->with('Success','Password changed successFully');
        }
        $error['old_password'] = 'the password didnot match';
        return back()->withErrors($error)->withInput($req->all());
    }

    public function userPoints(Request $req)
    {
        $user = Auth::user();
        return view('auth.user.point_info',compact('user'));
    }
}
