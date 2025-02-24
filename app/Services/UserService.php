<?php

namespace App\Services;

use App\Models\User;
use App\Services\ModelManagementService;

class UserService extends ModelManagementService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Get the followers of the user
     * 
     * @param User $user
     * @param int $id.
     */
    public function getFollowers(User $user, int $id = null)
    {
        return $id ?
            $user->find($id)->followers()->get() :
            $user->followers()->get();
    }

    /**
     * Get the following of the user
     * 
     * @param User $user
     * @param int $id.
     */
    public function getFollowing(User $user, int $id = null)
    {
        return $id ?
            $user->find($id)->following()->get() :
            $user->following()->get();
    }

    /**
     * Follow a user
     * 
     * @param User $user
     * @param int $id.
     */
    public function follow(User $user, int $id)
    {
        return $user->following()->attach($id);
    }

    /**
     * Unfollow a user
     * 
     * @param User $user
     * @param int $id.
     */
    public function unfollow(User $user, int $id)
    {
        return $user->following()->detach($id);
    }
}
