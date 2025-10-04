<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;

final class RegisterUser
{
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
