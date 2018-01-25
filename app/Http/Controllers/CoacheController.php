<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\User;
use App\Mail\NewCoachAdded;

class CoacheController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $collection = \App\assign::all();
        $users = \App\User::all();
        $coaches = \App\User::whereIn('status', [1, 2])->orderBy('name', 'asc')->get();
//                $collection->where('role_id', \App\role::coache())->unique("user_id");
//        return $coaches;



        return view('coache.index')->with('collection', $collection)
                        ->with('users', $users)->with("coaches", $coaches);
    }

    /**
     * Display a listing of the active packages.
     *
     * @return \Illuminate\Http\Response
     */
    public function activePackages(Request $request) {
        session(['role' => 'coach']);

        if (\Auth::user()->isAdmin())
            $assignments = \App\assignment::where('role_id', \App\role::coache())->get();
        else
            $assignments = \App\assignment::where('role_id', \App\role::coache())->where("user_id", \Auth::user()->id)->active()->get();

        $collection = \App\assignment::all();
        $users = \App\User::all();

        return view('coache.activepack')->with('assignments', $assignments->unique("package_id"))
                        ->with('collection', $collection)->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'status' => $data['status']
        ]);
    }

/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    use RegistersUsers;

    public function store(Request $request) {
        try {
            $user = \App\User::where('email', $request->email)->first();
            $error = 0;
//            var_dump($user);
//            var_dump($request->all());
            if (is_null($user)) {
                event(new Registered($user = $this->create($request->all())));
                \Mail::to($user->email)->send(new NewCoachAdded($user));
            } elseif ($user->first()->status != 0) {
                $user->status = 2;
                $user->save();
                \Mail::to($user->email)->send(new NewCoachAdded($user));
            } else {
                $user = "already exist";
                $error = 1;
            }



            return response()->json([$user, $error]);
        } catch (\Exception $e) {

            abort(500, 'OOps!!Some thing went wrong. Please try again.' . $user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($coach_id) {
//         $request->coache_id
        $this->authorize('destroyCoach', \App\User::class);
        $user = \App\User::find($coach_id);
        if (\App\assignment::where('user_id', $user->id)->count() > 0) {
            $coachRec = $user->assignments()->coach()->get();

            $umodules = \App\module::where('author_id', '=', $user->id)->delete();
            $upack = \App\package::whereIn('id', $coachRec->pluck('package_id'))->delete();
            $uclients = \App\assignment::whereIn('coache_id', $coachRec->pluck('id'))->delete();

            $udelcoach = \App\assignment::destroy($coachRec->pluck('id'));
        }
        if ($user->isClient()) {
            $user->status = 0;
            $user->save();
        } else {  //if (!$user->isAdmin()) 
            $udel = \App\User::destroy($user->id);
        }
        return back()->with('user', $user)->with('success', $user->name . ' has been deleted successfully.');
    }

    public function updateStatus(Request $request) {
        $assgnment = \App\assignment::where('role_id', \App\role::coache())->where('package_id', $request->package_id)->where('user_id', $request->coach_id)->first();
        echo "status : " . $request->status;
        if ($request->status)
            $assgnment->status = 5;
        else
            $assgnment->status = 0;
        $assgnment->save();
//        return back()->with('success', ' The package has been disabled successfully.');
    }

    public function uploadEditor(Request $request) {
        $name=pathinfo($request->photo->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $name."_".rand(11111, 99999) . "." . $request->photo->getClientOriginalExtension();
//        $fileName = $name. "." . $request->file->getClientOriginalExtension();
        $request->photo->move(public_path('images'), $fileName);

        return url("/images/".$fileName);

//        $sourcePath = $_FILES['file']['tmp_name'];       // Storing source path of the file in a variable
//        $targetPath = "/images/".$_FILES['file']['name']; // Target path where file is to be stored
//        move_uploaded_file($sourcePath,$targetPath) ;    // Moving Uploaded file

//        return var_dump($request->photo);

    }
}
