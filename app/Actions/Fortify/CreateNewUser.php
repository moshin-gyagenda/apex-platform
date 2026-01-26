<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Split name into first_name and last_name
        $nameParts = explode(' ', $input['name'], 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        $user = User::create([
            'name' => $input['name'],
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Assign 'client' role to the user
        try {
            // Check if 'client' role exists, if not create it
            $clientRole = Role::firstOrCreate(['name' => 'client'], [
                'guard_name' => 'web',
            ]);
            
            $user->assignRole($clientRole);
        } catch (\Exception $e) {
            // Log error but don't fail user creation
            \Log::warning('Failed to assign client role to user: ' . $e->getMessage());
        }

        return $user;
    }
}
