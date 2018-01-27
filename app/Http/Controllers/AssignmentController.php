<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NewResponse;

class AssignmentController extends Controller {

    public function show(Request $request, $assignment_id) {
        $role = $request->session()->get('role');
        $assignment = \App\assignment::find($assignment_id);

        if (\Auth::user()->isClient()) {
//            $role_id = \App\role::client();
            $client_id = \Auth::user()->id;
            $coach_id = \App\assignment::find($assignment->coache_id)->user_id;
        } else {
//            $role_id = \App\role::coache();
            $client_id = $assignment->user_id;
            $coach_id = \Auth::user()->id;
        }

        session(['client' => \App\User::find($client_id)]);
        session(['coach' => \App\User::find($coach_id)]);



        $module = \App\module::find($assignment->module_id);
        return view('module.preview')->with('module', $module)->with('assignment', $assignment);
//        return $package_id."/".$module_id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $package_id, $module_id) {
        $response = new \App\response();
        $response->content = $request->content;
        $response->save();

        $discussion = new \App\discussion();
        $discussion->user_id = $request->responseby;
        $discussion->question_id = $request->question_id;
        $discussion->assignment_id = $request->assignment_id;
        $discussion->response_id = $response->id;
        $discussion->save();

        $assignment = $discussion->assignment()->first();
//        replyoff
        if ($assignment->package()->first()->status == 0)
            $clientReply = true;
        else {
            $clientReply = false;
            $discussion->visibility = 1;
            $discussion->save();
        }
        // email to client on coach response
        $user = $discussion->user()->first();
        session(['assignment_id' => $assignment->id]);
//        if(\Auth::user()->isCoach() || \Auth::user()->isAdmin())
//            {
//            if($clientReply)
////            \Mail::to($assignment->user->email)->send(new NewResponse($user, 'coach', $assignment->module()->first()));
//        }
//        else{
//            if($clientReply)
//            \Mail::to($assignment->coach->email)->send(new NewResponse($user, 'client',$assignment->module()->first()));
//        }
//        // email to coach on client response


//        return back()->with('package_id', $package_id)->with('module_id', $module_id);
        return response()->json([
            'response'=>$response,
            'discussion'=>$discussion,
            'user'=>$user,
        ]);
    }

    public function updateStatus(Request $request) {
//        echo $request->assignment_id;
        if ($request->assignment_id == 0) {
            $assign = \App\assignment::create([
                        'role_id' => \App\role::client(),
                        'user_id' => $request->user_id,
                        'package_id' => $request->package_id,
                        'module_id' => $request->module_id,
                        'status' => $request->status,
                        'coache_id' => $request->coache_id
            ]);
        } else {
            $assign = \App\assignment::find($request->assignment_id);
            $assign->status = $request->status;
            $assign->save();
        }

        return back();
    }

    public function sendtoclient(Request $request,$assigned_id) {
        if($assigned_id == "" || $assigned_id == " " )
            $assigned_id = $request->assignment_id;
        $assignment = \App\assignment::find($assigned_id);
        \Mail::to($assignment->user->email)->send(new NewResponse(\Auth::user(), 'coach', $assignment->module()->first(), $assignment));

        return back();
    }

    public function sendtocoach(Request $request,$assigned_id) {
         if($assigned_id == "" || $assigned_id == " " )
            $assigned_id = $request->assignment_id;
         
        $assignment = \App\assignment::find($assigned_id);
//        var_dump($assignment->module()->first());
        \Mail::to($assignment->coach->email)->send(new NewResponse(\Auth::user(), 'client', $assignment->module()->first(), $assignment));

        return back();
    }

    public function savecontinue(Request $request,$assigned_id) {
         if($assigned_id == "" || $assigned_id == " " )
            $assigned_id = $request->assignment_id;
//     echo $assigned_id;    
        $assignment = \App\assignment::find($assigned_id);
        $user = \Auth::user();
//        $next_module = $assignment->package()->first()->modules()->where('modules.id', '!=', $assignment->module_id)->first();
        $modules =$assignment->package()->first()->selected_modules->pluck("id")->toArray();
        // email sending
        if ($user->can('sendclientAlert', $assignment)) {
             \Mail::to($assignment->coach->email)->send(new NewResponse(\Auth::user(), 'client', $assignment->module()->first(), $assignment));
             

        }
        elseif($user->can('sendcoachAlert', $assignment)){
            \Mail::to($assignment->user->email)->send(new NewResponse(\Auth::user(), 'coach', $assignment->module()->first(), $assignment));

        }
        
        
        
        if(count($modules)>0)
        {
            $next_module = array_search($assignment->module_id,$modules) + 1;
            if(array_key_exists($next_module, $modules))
            {
                $nm=\App\assignment::where('package_id', $assignment->package_id)->where('module_id', $modules[$next_module])->where('user_id', $assignment->user_id)->first();
                return redirect('/assigned/' . $nm->id);
            }
            else
                 return redirect('/assigned/' . $assignment->id)->with('success',"Last module of the package.");
                    
        }
         else
            return redirect('/assigned/' . $assignment->id)->with('success',"There is only one module in package.");
        
        
//        if ($next_module) {
//            $acount = \App\assignment::where('package_id', $assignment->package_id)->where('module_id', $next_module)->where('user_id', $assignment->user_id)->count();
//            if ($acount > 0) {
//                $assigned_module = \App\assignment::where('package_id', $assignment->package_id)->where('module_id', $next_module->id)->where('user_id', $assignment->user_id)->first();
//            } elseif ($acount > 1) {
//                $assigned_module = \App\assignment::create([
//                            'role_id' => \App\role::client(),
//                            'user_id' => $assignment->user_id,
//                            'package_id' => $assignment->package_id,
//                            'module_id' => $next_module,
//                            'coache_id' => $assignment->coache_id
//                ]);
//            } else {
//                $assigned_module = $assignment;
//            }
//
//            return redirect('/assigned/' . $assigned_module->id);
//        }
//        else
//            return back()->with('success',"There is only one module in package.");
    }

}
