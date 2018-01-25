<?php

namespace App\Policies;

use App\User;
use App\module;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModulePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the module.
     *
     * @param  \App\User  $user
     * @param  \App\module  $module
     * @return mixed
     */
    public function view(User $user, module $module)
    {
        //
    }

    /**
     * Determine whether the user can create modules.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the module.
     *
     * @param  \App\User  $user
     * @param  \App\module  $module
     * @return mixed
     */
    public function update(User $user, module $module)
    {
        //
    }

    /**
     * Determine whether the user can delete the module.
     *
     * @param  \App\User  $user
     * @param  \App\module  $module
     * @return mixed
     */
    public function delete(User $user, module $module)
    {
        //
    }
}
