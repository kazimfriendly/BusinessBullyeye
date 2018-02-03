<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class package extends Model {

    public $fillable = ['id', 'title', 'description', 'price', 'currency', 'paymnent_frequency', 'facebook_group', 'release_schedule','status'];
    protected $payment_frequencies = ['One Off', 'monthly', 'weekly', 'yearly'];
    protected $release_schedule = ['deliver immediately', 'rolling launch', 'one off launch', 'on completion of previous'];
    protected $appends = array('selected_modules', 'linked_clients');

//    protected $clients;

    public function getSelectedModulesAttribute() {
        return $this->modules()->orderby("pivot_id","asc")->get();
    }

    public function getLinkedClientsAttribute() {
        $l_clients = \App\assignment::where('package_id', $this->id)->where('role_id', \App\role::client())->get()->unique('user_id');
//        $l_clients = $this->getClients();
        return $l_clients;
    }

    public function setSelectedModulesAttribute($value) {
        $this->modules()->detach();
        $this->modules()->attach($value);
    }

//    public $selected_modules;
    public function getPaymentsFrequencies() {
        return $this->payment_frequencies;
    }

    public function getReleaseSchedule() {
        return $this->release_schedule;
    }

    /**
     * The modules that belong to the package.
     */
    public function modules() {
        return $this->belongsToMany('App\module', 'package_module')->withPivot('id')
    	->withTimestamps();;
    }

    /**
     * Get the associated assignments
     *
     * @var array
     */
    public function assignments() {

        return $this->hasMany('App\assignment');
    }

    public function getClients() {
        $clientsId = \App\assignment::where("package_id", $this->id)->where("role_id", \App\role::client())->pluck("user_id");
        $clients = \App\User::whereIn("id", $clientsId)->get();
        return $clients;

//        return "yes";
    }

    public function getCoach() {
        $clientsId = \App\assignment::where("package_id", $this->id)->where("role_id", \App\role::coache())->pluck("user_id");
        $coach = \App\User::whereIn("id", $clientsId)->first();
        return $coach;

//        return "yes";
    }

    public function scopeOwner($query) {

        if (\Auth::user()->status == 2) {
            return $query->join('assignments', 'packages.id', '=', 'assignments.package_id')
                            ->where('assignments.role_id', '=', \App\role::coache())
                            ->where('assignments.user_id', \Auth::user()->id)
                                    ->select("packages.*", "assignments.*", "assignments.id as assignment_id", "packages.id as id","packages.status as status","assignments.status as assign_status");
        }
//          App\package::join('assignments', 'packages.id', '=', 'assignments.package_id')->where('assignments.role_id', '=',3)->where('assignments.user_id', 1)->select("packages.*","assignments.*","assignments.id as assignment_id", "packages.id as id")->get();
        else {
            return $query;
        }
    }
    
    public function scopeActive($query) {
        if (\Auth::user()->status != 1)
            return $query->where('assignments.status', '!=', 5);
        else
            return $query;
    }

    
}
