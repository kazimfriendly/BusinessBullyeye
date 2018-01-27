<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\User;
use App\Mail\NewClientAdded;

class ClientController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        $collection = \App\assign::all();
        $users = \App\User::all();
        $coaches = \App\assignment::coach()->get()->unique('user_id');
//        return $coaches;



        return view('client.index')->with('collection', $collection)
                        ->with('users', $users)->with("coaches", $coaches);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create() {
//        //
//    }

/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    use RegistersUsers;

    public function store(Request $request) {
        $pack_id = $request->package_id;
        $request->password = bcrypt($request->password);
        $package = \App\package::find($request->package_id);
//        $user = \App\User::create([
//            'name'=>$request->name, 
//            'email' => $request->email, 
//            'password' => bcrypt($request->password),
//          
//        ]);
        try {
//            if (\App\User::where('email', '=', $request->email)->count() < 1) {
            event(new Registered($user = $this->create($request->all())));
//            }
            \Mail::to($user->email)->send(new NewClientAdded($user, $package));
//        $clientRole = \App\role::client();
            $assign = new \App\assign();
//        $client = $assign->client($user->id, $request->package_id);
//            $role_id = \App\role::client();
//            $pack = $assign->getPackage($request->package_id);
//            $coache = $assign->getCoache($request->package_id);

            $assign->client($user->id, $pack_id);
//        $client->role_id = $clientRole;
//        $client->user_id = $user->id;
//        $client->package_id = $request->package_id;
//        $client->save();
            $package_clients = $package->linked_clients;

            return response()->json([
                        'client' => $package_clients,
                        'totalclients' => $package_clients->count()
            ]);
        } catch (\Exception $e) {
            abort(500, 'User Already Exist.');
        }
    }

    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'status' => 0
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeExisting(Request $request) {

        $pack_id = $request->package_id;
        $emails = $request->emails;
        $emails = preg_replace('/\s+/', '', $emails);
        $users = \App\User::whereIn('email', explode(",", $emails))->get();
        $package = \App\package::find($request->package_id);

        $clients = [];
        if($users->count() <1)
            abort(500, 'User Not Exist.');
        
        foreach ($users as $user) {

            if (\App\assignment::where('user_id', $user->id)->where('package_id', $request->package_id)->count() < 1) {
                $assign = new \App\assign();
                $assign->client($user->id, $request->package_id);
                \Mail::to($user->email)->send(new NewClientAdded($user, $package));
                $clients[] = $user->email;
            } else {
                abort(500, 'User Already Exist.');
            }
        }
        $package_clients = $package->linked_clients;
        return response()->json([
                    'clients' => implode(", ", $clients),
                    'totalclients' => $package_clients->count()
        ]);
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
    public function destroy(Request $request, $client_id) {
//return $request->coache_id;
        $this->authorize('destroy', \App\User::class);
        $user = \App\User::find($client_id);
        if (isset($request->package_id)) {
            $udel = \App\assignment::where('package_id', $request->package_id)->where('user_id', $client_id)->delete();
          
        } else {
            $udel = \App\assignment::where('coache_id', $request->coache_id)->where('user_id', $client_id)->delete();
        }
//  return $udel;      
        return back()->with('user', $user)->with('success', $user->name . ' has been deleted successfully.');
    }

    /**
     * Display a listing of the active packages.
     *
     * @return \Illuminate\Http\Response
     */
    public function activePackages(Request $request) {
//return "yesr";
        session(['role' => 'client']);
//        $pack = \App\assign::where('role_id', \App\role::client())->where("user_id",\Auth::user()->id)->pluck("package_id")->all();
//        $packages= \App\package::whereIn("id",$pack)->get();

        if (\Auth::user()->isAdmin())
            $collection = \App\assignment::where('role_id', \App\role::client())->get();
        else
            $collection = \App\assignment::where('role_id', \App\role::client())->where("user_id", \Auth::user()->id)->active()->get();

        return view('client.activepack')->with('assignments', $collection->unique("package_id"))->with('collection', $collection);
    }

}
