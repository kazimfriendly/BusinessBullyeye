<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user_id) {
        $user = User::find($user_id);
        return view('profile.index')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id) {
        $user = User::find($user_id);
        return view('profile.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id) {
        $msg = "Password and Confirm Password should be same.";
        $user = User::find($user_id);
        if ($request->type == 'detail') {
            $user->name = $request->name;
            $user->description = $request->description;
            $msg = "Profile Information Updated";
        } elseif ($request->type == 'cpasword') {
            if ($request->password == $request->password_confirmation) {
                $user->password = bcrypt($request->password);
                $msg = "Password updated successfully.";
            }
        } elseif ($request->type == 'dp') {
//            return var_dump($request->file('avatar'));
            $path = $request->file('avatar')->store('avatar/'.$request->user()->id,'public'); 
//            Storage::setVisibility($path, 'public');
            $user->avatar = $path;
            $msg = 'Avatar updated successfully.';
        }
        $user->save();
        return back()->with('success', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        //
    }

}
