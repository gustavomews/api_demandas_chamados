<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demands', function (Blueprint $table) {
            $table->id(); // Number
            $table->string('title', 40);
            $table->text('description')->nullable();
            $table->datetime('datetime_open')->useCurrent();
            $table->datetime('datetime_end')->nullable();
            $table->bigInteger('user_id');
            $table->smallInteger('status_id')->default(1);
            $table->timestamps();

            // FK
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demands');
    }
}
