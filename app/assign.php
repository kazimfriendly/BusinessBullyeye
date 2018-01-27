<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assign extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assignments';

    public function client($auser_id, $apackage_id) {

        $role_id = \App\role::client();
       
        $pack= $this->getPackage($apackage_id);
        $coache = $this->getCoache($apackage_id);
//         $module = $pack->selected_modules->first();
        foreach($pack->selected_modules as $module)
        {
             \App\assignment::create(['role_id' => $role_id, 'user_id' => $auser_id, 'package_id' => $apackage_id, 'module_id' => $module->id, 'status' => 3, 'coache_id' => $coache->id]);
             }

        return $this;
    }
    
    public function getPackage($package_id){
        return \App\package::where('id',$package_id)->first();
    }

    public function coache($auser_id, $apackage_id, $status=3) {

        $this->role_id = \App\role::coache();
        $this->user_id = $auser_id;
        $this->package_id = $apackage_id;
        $this->module_id = $this->getPackage($apackage_id)->selected_modules->first()->id;
        $this->status = $status;    
        $this->save();

        return $this;
    }

    public function getName($users) {
        $user = $users->where("id", $this->user_id)->first();
        return $user->name;
        
//        return "yes";
    }

    public function getEmail($users) {
        $user = $users->where("id", $this->user_id)->first();
        return $user->email;
        
//        return "yes";
    }

    public function getUserStatus($users) {
        $user = $users->where("id", $this->user_id)->first();
        return $user->status;
        
//        return "yes";
    }
    
     public function getClients($users,$collection) {
        $coach_ids = $collection->where("user_id",  $this->user_id)->where("role_id",\App\role::coache())->unique("package_id")->pluck("id");
        $clientsId = $collection->whereIn("coache_id",$coach_ids)->unique("user_id")->pluck("user_id");
        $clients=$users->whereIn("id",$clientsId);
        return $clients;
        
//        return "yes";
    }
    
    public function getPackages($users,$collection) {
        $pack = $collection->where("user_id",  $this->user_id)->unique("package_id")->pluck("package_id");
        $pacakages= \App\package::whereIn("id",$pack)->get();
        return $pacakages;
        
//        return "yes";
    }
    
    public function getCoache($package_id){
//        if(\Auth::user()->isAdmin()){
       return \App\assignment::where("role_id",\App\role::coache())->where('package_id',$package_id)->where('user_id',\Auth::user()->id)->first();            
//        } else {
//        return \App\assignment::where("role_id",\App\role::coache())->where('package_id',$package_id)->where('user_id',$user_id)->first();
            
//        }
    }
    public function getClientsCoach($package_id){
        return \App\assignment::where("role_id",\App\role::client())->where('package_id',$package_id)
                ->where("user_id",$this->user_id)->first();
    }

}
