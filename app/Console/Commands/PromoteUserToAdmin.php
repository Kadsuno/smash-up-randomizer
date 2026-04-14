<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteUserToAdmin extends Command
{
    protected $signature = 'users:promote {email : The e-mail address of the user to promote}';
    protected $description = 'Promote an existing user to the admin role';

    public function handle(): int
    {
        $email = $this->argument('email');
        $user  = User::where('email', $email)->first();

        if (! $user) {
            $this->error("No user found with e-mail address: {$email}");
            return self::FAILURE;
        }

        if ($user->isAdmin()) {
            $this->warn("User {$email} already has the admin role.");
            return self::SUCCESS;
        }

        $user->update(['role' => 'admin']);
        $this->info("User {$email} has been promoted to admin.");

        return self::SUCCESS;
    }
}
