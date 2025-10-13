<?php

namespace App\Actions\Auth;

use App\Enums\Company\UserRole;
use App\Enums\Company\UserStatus;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class RegisterUser
{
    /**
     * Execute the action.
     */
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $company = Company::create([
                'name' => $data['company_name'],
                'slug' => Str::slug($data['company_name']),
            ]);

            return User::create([
                'company_id' => $company->id,
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => $data['password'], // Password is hashed via model mutator.
                'status' => UserStatus::ACTIVE->value,
                'role' => UserRole::OWNER->value,
            ]);
        });
    }
}
