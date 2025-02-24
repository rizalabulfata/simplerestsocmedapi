<?php

namespace App\Services;

use App\Models\User;
use App\Services\ModelManagementService;

class UserService extends ModelManagementService
{
    public function __construct(User $model = new User())
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
            $user->find($id)->followings()->get() :
            $user->followings()->get();
    }

    /**
     * Follow a user
     * 
     * @param User $user
     * @param int $id.
     */
    public function follow(User $user, int $id)
    {
        return $user->followings()->attach($id);
    }

    /**
     * Unfollow a user
     * 
     * @param User $user
     * @param int $id.
     */
    public function unfollow(User $user, int $id)
    {
        return $user->followings()->detach($id);
    }
}
