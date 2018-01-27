<?php

namespace App\Http\Controllers;

use App\module;
use Illuminate\Http\Request;

class ModuleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $modules = module::where('is_live', false)->author()->get();
        $live_modules = module::where('is_live', true)->author()->get();
        
       
        return view('module.index')->with('modules', $modules)
                        ->with('live_modules', $live_modules);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
//        $module = new module();
//        $module->title = "New Module Title";
//        $module->description 
        return view('module.create')->with('state','add');
    }

    /**
     * Available modules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function getLive() {
        $module = module::all()->where('is_live', true);
        return response()->json($module);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $module = module::create($request->all());
        return response()->json(['module'=>$module, 'url'=>url('modules/'.$module->id)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function show($module_id) {
        $module = module::find($module_id);
//        $assignment = \App\assignment::where('user_id',Auth::user()->id)->where('package_id',$module->package())
        return view('module.preview')->with('module', $module);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit($module_id) {
        $module = module::find($module_id);
//        return response()->json($module);
//        return var_dump($module);
        return  view('module.create')->with('state','update')
                ->with('module',$module);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $module_id) {
        $module = module::find($module_id);
        $module->title = $request->title;
        $module->description = $request->description;
        $module->content = $request->content;
        $module->save();
        return response()->json($module);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy($module_id) {
        $module = module::destroy($module_id);
        return response()->json($module);
    }

    /**
     * update to live module.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function makeLive($module_id) {
        $module = module::find($module_id);
        $module->is_live = true;
        $module->save();
        return response()->json($module);
    }

    /**
     * copy a module.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function makeCopy($module_id) {
        $module = module::find($module_id);
        $copy_of_module = $module->replicate();
        $copy_of_module->title = "[COPY OF]" . $copy_of_module->title;
        $copy_of_module->is_live = 0;
        $copy_of_module->save();
        $copy_questions = [];
        foreach ($module->questions()->get() as $quesCopy) {
            $copy_questions[] = $quesCopy->replicate();
        }
        $copy_of_module->questions()->saveMany($copy_questions);

        $documents_copy = [];
        foreach ($module->documents()->get() as $documentCopy) {
            if(file_exists(public_path('documents/' .  $documentCopy->filename))) {        
                $orignalName =explode('.', $documentCopy->filename);
                $fileName = $orignalName[0]."_" . $copy_of_module->id . "." . $orignalName[1];
                copy(public_path('documents') . '/' . $documentCopy->filename, public_path('documents') . '/' . $fileName);            
                $newCopy=$documentCopy->replicate();
                $newCopy->filename = $fileName;
                $documents_copy[] = $newCopy;
            }            
        }

        $copy_of_module->documents()->saveMany($documents_copy);
        return back()->with('success', 'Module copy successfully.');
    }

}
