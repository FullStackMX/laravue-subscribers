<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                ->unique();
            $table->string('title')
                ->index();
            $table->enum('type', [
                    'boolean',
                    'date',
                    'list',
                    'number',
                    'string',
                ])
                ->default('string')
                ->index();
            $table->json('meta')
                ->nullable();
            $table->boolean('protected')
                ->default(0)
                ->index();
            $table->boolean('required')
                ->default(1)
                ->index();
            $table->timestamps();
            $table->softDeletes()
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     *m
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}
