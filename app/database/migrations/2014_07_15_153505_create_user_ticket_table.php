<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTicketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_tickets', function(Blueprint $table)
		{
            $table->primary(['user_id', 'ticket_id']);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('ticket_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_tickets');
	}

}
