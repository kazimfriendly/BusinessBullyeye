<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question extends Model {

    public $fillable = ['sno', 'content', 'module_id'];

    /**
     * Get the module that owns the documents.
     */
    public function module() {
        return $this->belongsTo('App\module');
    }

    /**
     * Get the associated discussions
     *
     * @var array
     */
    public function discussions(){
     
        return $this->hasMany('App\discussion');
    
    }
    /**
     * Get the associated discussions
     *
     * @var array
     */
//    public function discussions() {
//
//        return $this->hasMany('App\discussion');
//    }

//    @php
//                        $discussion= \App\discussion::getResponses($question,$assignment);
//                        @endphp

    public function getDiscussion($assignment_id) {
//        $client = session('client')
//        $assignment_ids = \App\assignment::where("module_id", $assignment->module_id)
//                ->where("package_id",$assignment->package_id)
//                ->whereIn('user_id',[session('client')->id,session('coach')->id])
//                ->pluck("id");
        $responses = \App\discussion::where('question_id', $this->id)->where('assignment_id', $assignment_id)->get();
        return $responses;
    }

}
