<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    
    protected $appends = array('client','coache');
    
    
    public static function client(){
        $client=self::where('name', 'client')->first();
        return $client->id ;
    }
    
    public static function coache(){
        $coache = self::where('name', 'coache')->first();
        return  $coache->id;
    }
}
