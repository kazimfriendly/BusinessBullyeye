<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class response extends Model
{
    
    
    /**
     * Get the associated discussions
     *
     * @var array
     */
    public function discussion(){
     
        return $this->hasMany('App\discussion');
    
    }
}
