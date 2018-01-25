<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class discussion extends Model {

    public $fillable = ['user_id', 'question_id', 'response_id', 'assignment_id'];

    /**
     * Get the ownner.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the ownner.
     */
    public function question() {
        return $this->belongsTo('App\question');
    }

    /**
     * Get the ownner.
     */
    public function response() {
        return $this->belongsTo('App\response');
    }

    /**
     * Get the ownner.
     */
    public function assignment() {
        return $this->belongsTo('App\assignment');
    }

    public static function getResponses($question, $assignment) {
        $responses = self::where('question_id', $question->id)->where('assignment_id', $assignment->id)->get();
        return $responses;
    }

//    @php
//                                    $author=\App\User::find($response->user_id);
//                                    $response_detail=\App\response::find($response->id);
//                                @endphp


    public function getAName($user_id) {
        $author = \App\User::find($user_id);
        return $author->name;
    }
    
    public function getAvatar($user_id) {
        $author = \App\User::find($user_id);
        return $author->avatar;
    }

    public function getContent($response_id){
        $response_detail= \App\response::find($response_id);
        return $response_detail->content;
    }
    
    public function getTime($response_id){
        $response_detail= \App\response::find($response_id);
        return date("D F j, Y",  strtotime($response_detail->created_at));
    }
}
