<?php

use Task\Model\User;
use Task\Model\Project;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $user = $this->generateUser();
        $this->createBaseProject($user);


		// $this->call('UserTableSeeder');
	}

    public function generateUser()
    {
        return User::create([
            'first_name' => 'Logan',
            'last_name' => 'Bailey',
            'email' => 'logan@logansbailey.com',
            'logout_at' => '2015-01-01 00:00:00'
        ]);
    }

    public function createBaseProject(User $user)
    {
        $project = new Project();
        $project->name = 'Task Tracker';
        $project->description = 'A developer tool use to track the assigning and completion of tickets.';
        $project->save();

        $project->users()->save($user);
    }

}
