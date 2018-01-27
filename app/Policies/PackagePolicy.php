<?php

namespace App\Policies;

use App\User;
use App\Package;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy {

    use HandlesAuthorization;

    public function edit(User $user, Package $package) {

        if (isset($package->assign_status)) {
            if ($package->assign_status == 4 || $package->assign_status == 5)
                return false;
            else
                return true;
        } else
            return true;
    }

    public function assignCoach(User $user, Package $package) {

        if (\Auth::user()->isAdmin())
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can view the package.
     *
     * @param  \App\User  $user
     * @param  \App\Package  $package
     * @return mixed
     */
    public function view(User $user, Package $package) {
        //
        return !($this->edit($user, $package));
    }

    /**
     * Determine whether the user can create packages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user) {
        //
    }

    /**
     * Determine whether the user can update the package.
     *
     * @param  \App\User  $user
     * @param  \App\Package  $package
     * @return mixed
     */
    public function update(User $user, Package $package) {
//        $package->assignments()
//        $package
    }

    /**
     * Determine whether the user can delete the package.
     *
     * @param  \App\User  $user
     * @param  \App\Package  $package
     * @return mixed
     */
    public function delete(User $user, Package $package) {
        //
    }

}
