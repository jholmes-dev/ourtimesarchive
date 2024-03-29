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
        Schema::create('unlocks', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->timestamps();
            $table->integer('current_entry');
            $table->integer('user_id');
            $table->integer('vault_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unlocks');
    }
};
