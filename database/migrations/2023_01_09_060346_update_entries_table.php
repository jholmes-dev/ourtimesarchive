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
        Schema::table('entries', function(Blueprint $table) {
            $table->string('title', 256)->nullable();
            $table->string('content', 10240)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function(Blueprint $table) {
            $table->dropColumn('title');
            $table->text('content')->change();
        });
    }
};
