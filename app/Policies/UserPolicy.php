<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
     public function destroy(User $user)
    {
        return (\Auth::user()->isAdmin() || \Auth::user()->isCoach());
    }
    
     public function destroyCoach(User $user)
    {
        return (\Auth::user()->isAdmin());
    }
}
