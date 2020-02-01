<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
			$table->string('ticket_no');
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->longText('description')->nullable();
			$table->integer('status')->default(1);
			$table->integer('user_assigned_id')->default(0);
			$table->integer('added_by')->default(0);			
			
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
        Schema::dropIfExists('tickets');
    }
}
