<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('type');
            $table->tinyInteger('status', false, true)->default(\Task\Model\Ticket\Status::WAITING);
            $table->unsignedInteger('reporter_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('assignee_id')->nullable();
            $table->date('due_at')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tickets');
	}

}
