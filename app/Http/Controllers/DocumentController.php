<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\document;
use App\module;

class DocumentController extends Controller {

    public function docUploadPost(Request $request) {
//        $this->validate($request, [
//            'document' => 'required|max:2048',
//            'description' => 'required'
//        ]);

        $rules = array('document' => 'required|max:2048',
            'description' => 'required');
        $validator = \Validator::make($request->all(), $rules);
        // Validate the input and return correct response
        if ($validator->fails()) {
            session(['module_id_doc'=>$request->doc_module_id]);
            return back()->withErrors($validator)
                        ->withInput()->with("module_id",$request->doc_module_id); // 400 being the HTTP code for an invalid request.
        }
//        $fileName = $request->document->getClientOriginalName();
        $name=pathinfo($request->document->getClientOriginalName(), PATHINFO_FILENAME);
        //$fileName = $name."_".rand(11111, 99999) . "." . $request->document->getClientOriginalExtension();
        $fileName = $name. "." . $request->document->getClientOriginalExtension();

        $orignalName =explode('.', $fileName);
        $fileName = $orignalName[0]."_" . $request->doc_module_id . "." . $orignalName[1];                

        $request->document->move(public_path('documents'), $fileName);

        // insert to database
        $doc = new document();
        $doc->description = $request->description;
        $doc->module_id = $request->doc_module_id;
        $doc->uploaded_by = \Auth::user()->id;
        $doc->filename = $fileName;


        $doc->save();

        return back()->with('success', 'Document uploaded successfully.')
                        ->with('model', '#documentModel');
    }

    public function destroy($doc_id) {
        $doc_file = document::where('id', $doc_id)->first();
        
        if(file_exists(public_path('documents/' . $doc_file->filename))) {
            unlink(public_path('documents/' . $doc_file->filename));            
        }
        $doc = document::destroy($doc_id);
        return response()->json($doc);
    }

    public function listModuleDoc($module_id) {
        $documents = module::find($module_id)->documents()->get();
        return response()->json($documents);
    }

}
