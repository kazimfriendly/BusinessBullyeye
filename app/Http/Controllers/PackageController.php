<?php

namespace App\Http\Controllers;

use App\package;
use Illuminate\Http\Request;
use App\module;
use App\Mail\NewPackageAdded;

class PackageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $packages = package::owner()->active()->get();
        $epackage = new package();
        $live_modules = module::where('is_live', true)->author()->get();

        return view('package.index')->with('packages', $packages)->with('epackage', $epackage)
                        ->with('live_modules', $live_modules);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        $epackage = new package();
        $live_modules = module::where('is_live', true)->author()->get();

        return view('package.create')->with('epackage', $epackage)->with('state', 'add')
                        ->with('live_modules', $live_modules);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $package = package::create($request->all());
        $package->modules()->attach($request->selected_modules);
        // auto set coache
        $assign = new \App\assign();

//        if (auth()->user()->status == 2)
        $assign->coache(auth()->user()->id, $package->id);
//        else
//            $assign->coache($request->coach, $package->id);



        return response()->json($package);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function show($package_id) {
        $package = package::owner()->find($package_id);
        $this->authorize('edit', $package);

//        $package->selected_modules ='["2","5"]';  //$package->modules()->get();
//        return response()->json($package);
        $epackage = new package();
        $live_modules = module::where('is_live', true)->author()->get();

        return view('package.create')->with('epackage', $epackage)->with('state', 'update')
                        ->with('live_modules', $live_modules)->with("package", $package);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($package_id) {
        $package = package::find($package_id);

//        return response()->json($package)->with('selected_modules',$package->modules()->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $package_id) {
        $package = package::owner()->find($package_id);
        $package->title = $request->title;
        $package->description = $request->description;
        $package->price = $request->price;
        $package->currency = $request->currency;
        $package->release_schedule = $request->release_schedule;
        $package->paymnent_frequency = $request->paymnent_frequency;
        $package->facebook_group = $request->facebook_group;
//        $package->selected_modulels = $request->selected_modules;
        $package->save();
        $package->setSelectedModulesAttribute($request->selected_modules);
        $assignment = \App\assignment::where('package_id', $package->id)->whereNotIn('module_id', $request->selected_modules)->delete();

        $previous = \App\assignment::where("package_id", $package->id)->pluck('module_id')->unique("moudle_id")->toArray();
     
        $selected = $request->selected_modules;

        $new = array_diff($selected, $previous);

        $role_id = \App\role::client();
        if (count($new) > 0) {

            foreach ($new as $module_id) {
                $clients = \App\assignment::where("package_id", $package->id)->where("role_id", $role_id)->get()->unique("user_id");
                foreach ($clients as $client) {
                    \App\assignment::create(['role_id' => $role_id, 'user_id' => $client->user_id, 'package_id' => $package->id, 'module_id' => $module_id, 'status' => 3, 'coache_id' => $client->coache_id]);
                }
            }
        }
        return response()->json($package);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy($package_id) {
        $package = package::find($package_id);
        $pack = package::destroy($package_id);
        return back()->with('pack', $pack)->with('success', $package->title . ' has been deleted successfully.');
    }

    public function showLinkedClients($package_id) {
        $package = package::find($package_id);
        return response()->json(['clients' => $package->getClients(), 'coach' => $package->getCoach()]);
    }

    /**
     * copy a package.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function makeCopy($package_id) {
        $package = package::find($package_id);
        $copy_of_package = $package->replicate();
        $copy_of_package->title = "[COPY OF] " . $copy_of_package->title;

        $copy_of_package->save();
//        
        $copy_of_package->modules()->saveMany($package->modules()->get());
        // auto set coache
        $assign = new \App\assign();
        $assign->coache(auth()->user()->id, $copy_of_package->id);

        return back();
    }

    public function updateStatus(Request $request, $package_id) {
        $package = package::find($package_id);

        $package->status = 1;
        $package->save();
        return back()->with('success', ' The status of "' . $package->title . ' " has been updated successfully.');
    }

    public function assignCoachForm(Request $request, $package_id) {
        $package = package::find($package_id);
        $coaches = \App\User::whereIn('status', [1, 2])->orderBy('name', 'asc')->get();
        $alreadyAssigned = \App\assignment::where('package_id', $package->id)
                        ->where("role_id", \App\role::coache())->pluck("user_id");
        $assignedCoaches = \App\User::whereIn("id", $alreadyAssigned)->get();
        return view('package.assign_coach')->with('package', $package)->with('coaches', $coaches)
                        ->with('assignedCoaches', $assignedCoaches);
    }

    public function assignCoach(Request $request) {
        $package = package::find($request->package_id);
        $assign = new \App\assign();
        $alreadyAssigned = \App\assignment::whereIn('user_id', $request->assignedCoaches)->where('package_id', $package->id)->where("role_id", \App\role::coache())->get();
        foreach ($request->assignedCoaches as $coachid) {
            if ($alreadyAssigned->where('user_id', $coachid)->count() < 1) {
                $assign->coache($coachid, $package->id, 4);
                $user = \App\User::find($coachid);
                \Mail::to($user->email)->send(new NewPackageAdded($user,$package));
            }
        }


        return redirect("packages/")->with('success', 'Coach(es) assigned successfully.');
    }

    public function view($package_id) {
        //
        $package = package::find($package_id);

//        
        $epackage = new package();
        $live_modules = module::where('is_live', true)->author()->get();

        return view('package.view')->with('epackage', $epackage)->with('state', 'update')
                        ->with('live_modules', $live_modules)->with("package", $package);
    }

}
