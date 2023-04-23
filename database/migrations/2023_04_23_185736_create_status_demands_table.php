<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_demands', function (Blueprint $table) {
            $table->id();
            $table->string('title', 12);
            $table->string('codename', 7);
            $table->timestamps();
        });

        Schema::table('demands', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('status_demands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_demands');
    }
}
