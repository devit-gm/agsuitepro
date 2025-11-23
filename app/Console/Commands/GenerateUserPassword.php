<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\User;

class GenerateUserPassword extends Command
{
    protected $signature = 'user:generate-password {user_id}';
    protected $description = 'Generate a random password for a user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if ($user) {
            $password = Str::password(12);
            $user->password = bcrypt($password);
            $user->save();

            $this->info('Password generated successfully: ' . $password);
        } else {
            $this->error('User not found');
        }
    }
}
