<?php

namespace App\Policies;

use App\User;
use App\Note;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApoderadoPolicy
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

    public function showchild(User $user)
    {
         return true;
    }
}
