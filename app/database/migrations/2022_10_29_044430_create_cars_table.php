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
        Schema::create('cars', function (Blueprint $table) {
            $table->id('car_id');
            $table->string('reg_num', 30)->comment('гос. номер');
            $table->string('model', 90)->comment('модель авто');
            $table->foreignId('car_user_id')
                    ->nullable()
                    ->unique()
                    ->comment('каой пользовтель управляет машиной');
            $table->timestamps();

            $table->foreign('car_user_id')
                    ->references('car_user_id')
                    ->on('car_users')
                    ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
