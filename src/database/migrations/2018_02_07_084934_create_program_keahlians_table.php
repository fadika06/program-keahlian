<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProgramKeahliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('program_keahlians', function(Blueprint $table) {
			$table->increments('id');
			$table->string('label');
			$table->string('keterangan');
			$table->integer('user_id')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::drop('program_keahlians');
	}
}
