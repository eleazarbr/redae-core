<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;

final class RegisterUser
{
    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     */
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {
            return User::create([
              'name'     => $data['name'],
              'email'    => $data['email'],
              'password' => $data['password'], // Password is hashed via model mutator.
            ]);
        });
    }
}
