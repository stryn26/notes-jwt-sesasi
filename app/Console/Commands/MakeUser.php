<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class MakeUser extends Command
{
    protected $signature = 'make:user';
    protected $description = 'Create Super User';

    public function handle()
    {
        $name = $this->ask('Enter the user name');
        $email = $this->ask('Enter the user email');
        $password = $this->ask('Enter the user password');

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string', 
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $this->info('Validation failed. User not created.');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error); // Display each validation error
            }
        } else {
            $user->password = bcrypt($password); 
            $user->role = 'admin'; // Role 'admin' ditetapkan setelah validasi
            $user->save();
            $this->info('User created successfully.');
        }
    }
}
