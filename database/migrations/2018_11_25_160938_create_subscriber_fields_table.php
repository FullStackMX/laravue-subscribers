<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriberFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriber_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscriber_id')
                ->unsigned();
            $table->integer('field_id')
                ->unsigned();
            $table->string('value')
                ->nullable()
                ->index();
            $table->timestamps();
            $table->softDeletes()
                ->index();

            $table->foreign('subscriber_id')
                ->references('id')
                ->on('subscribers')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('field_id')
                ->references('id')
                ->on('fields')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriber_fields');
    }
}
