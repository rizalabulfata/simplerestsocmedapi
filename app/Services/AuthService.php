<?php

namespace App\Services;

use App\Models\User;
use App\Services\ModelManagementService;
use Illuminate\Support\Facades\Hash;

class AuthService extends ModelManagementService
{
    public function __construct(User $model = new User())
    {
        parent::__construct($model);
    }

    /**
     * Register a new user
     * 
     * @param array $record
     * @return array
     */
    public function registerUser($record): array
    {
        $record['password'] = bcrypt($record['password']);
        $user = $this->repository->create($record);
        $token = $user->createToken('auth_token');

        return [$user, $token];
    }

    /**
     * Login a user
     * 
     * @param array $record
     * @return array
     */
    public function loginUser($record): bool|array
    {
        $user = $this->repository->getModel()->where('email', $record['email'])->first();
        if (!$user || !Hash::check($record['password'], $user->password)) {
            return false;
        }

        $token = $user->createToken('auth_token');

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
            'type' => 'Bearer',
            'token_details' => $token
        ];
    }

    /**
     * Logout a user
     * 
     * @param User $user
     * @param bool $allToken
     * @return string
     */
    public function logoutUser(User $user, $allToken = false): bool
    {
        $status = $allToken ?
            $user->tokens()->delete() :
            $user->currentAccessToken()->delete();

        return $status;
    }
}
