<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class document extends Model
{
     public $fillable = ['description','filename','uploaded_by','uploaded_at' ,'module_id'];
     
      /**
     * Get the module that owns the documents.
     */
    public function module()
    {
        return $this->belongsTo('App\module');
    }
     
}
