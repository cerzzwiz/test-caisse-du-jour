<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saisie_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('saisie_id')->nullable();
            $table->float('nominal')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('block_type')->nullable();

            $table->foreign('saisie_id')->references('id')->on('saisies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saisie_details');
    }
};
