<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('configurations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('key')->unique();
                $table->string('display_name');
                $table->text('value')->nullable();
                $table->text('details')->nullable();
                $table->string('type');
                $table->integer('order')->default('1');
                $table->string('group')->nullable();
                $table->timestamps();
            });
        } catch (PDOException $ex) {
            $this->down();

            throw $ex;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
