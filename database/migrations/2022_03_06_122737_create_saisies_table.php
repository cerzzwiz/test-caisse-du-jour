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
        Schema::create('saisies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('type_operation_id')->nullable();
            $table->datetime('date')->nullable();
            $table->text('comment')->nullable();

            $table->foreign('type_operation_id')->references('id')->on('type_operations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saisies');
    }
};
