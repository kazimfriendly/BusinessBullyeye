<?php

namespace App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class module extends Model {

    public $fillable = ['title', 'description', 'content', 'is_live', 'author_id'];

    public static function boot() {
        parent::boot();


        // create a event to happen on saving
        static::creating(function($table) {
            $table->author_id = \Auth::user()->id;
        });

        //order by id asc
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderby('id', 'asc');
        });
    }

    public function scopeAuthor($query) {

        if (\Auth::user()->status == 2)
            return $query->where('author_id', '=', \Auth::user()->id);
        else
            return $query;
    }

    /**
     * Get the associated documents
     *
     * @var array
     */
    public function documents() {

        return $this->hasMany('App\document');
    }

    /**
     * Get the associated questions
     *
     * @var array
     */
    public function questions() {

        return $this->hasMany('App\question');
    }

    /**
     * The packages that belong to the module.
     */
    public function packages() {
        return $this->belongsToMany('App\package', 'package_module');
    }

    /**
     * The coach that belong to the module.
     */
    public function author() {
        return $this->belongsTo('App\User');
    }

}
