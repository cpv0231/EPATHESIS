<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
		$user->firstname = 'Christian';
		$user->lastname = 'Villaruel';
		$user->email = 'admin@gmail.com';
		$user->password = Hash::make('adminadmin');
		$user->address1 = 'Quezon';
		$user->address2 = 'Gumaca';
		$user->admin = 1;
		$user->save();
	
    }
}
