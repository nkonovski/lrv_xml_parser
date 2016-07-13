<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Books extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create books table
		Schema::create('books', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('author');
			$table->string('title');
			$table->boolean('active');
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
		// drop books table
		Schema::drop('books');
    }
}
