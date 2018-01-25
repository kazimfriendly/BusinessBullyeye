<?php

namespace App\Http\Controllers;

use App\question;
use App\module;
use Illuminate\Http\Request;

class QuestionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grid($module_id) {
        $questions = module::find($module_id)->questions()->orderBy('sno')->get();
        return response()->json($questions);
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
         $question = question::create($request->all());
        return response()->json($question);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function show($question_id) {
        $question = question::find($question_id);
        return response()->json($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(question $question) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $question_id) {
        $question = question::find($question_id);
        $question->sno = $request->sno;
        $question->content = $request->content;
        $question->save();
        return response()->json($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($question_id) {
        $doc = \App\question::destroy($question_id);
        return response()->json($doc);
    }
    
     public function sort(Request $request) {
         foreach ($request->json()->all() as $sq){
//             var_dump($sq['q_id']);
        $question = question::find($sq['q_id']);
        $question->sno = $sq['sno'];
        
        $question->save();
             }
         
        return response()->json("sorting done.");
//         return $request->json($question);
    }

}
