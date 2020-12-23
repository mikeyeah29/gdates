<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use \App\User;
use App\Lib\Roles\UserRole;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a superadmin user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $role = $this->choice(
            'What role does this user have?',
            UserRole::getRoleList(),
        );

        if($role === 'ROLE_SUPER_ADMIN') {
            // check if super admin exists
            $user = User::where('roles', 'like', '%ROLE_SUPER_ADMIN%')->first();
            if($user){
                // already exists
                $this->info('Super Admin already exists using the email ' . $user->email);
                die();
            }
        }

        $firstName = $this->ask('What is your first name?');
        $lastName = $this->ask('What is your last name?');
        $email = $this->ask('What is the users email address?');
        $password = $this->secret('Enter a password...');

        $user = new User();

        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->addRole($role);
        $user->email_verified_at = now();

        $user->save();        

        $this->info('user created for email address ' . $user->email);
    }
}
