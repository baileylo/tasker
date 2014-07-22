<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        \Task\Model\User::create([
            'first_name' => 'Logan',
            'last_name' => 'Bailey',
            'email' => 'logan@logansbailey.com',
            'logout_at' => '2015-01-01 00:00:00'
        ]);

		// $this->call('UserTableSeeder');
	}

}
