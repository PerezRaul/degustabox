<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_trackers', function (Blueprint $table) {
            $table->char('id', 36)->unique()->primary();
            $table->string('name');
            $table->date('date');
            $table->time('starts_at_time');
            $table->time('ends_at_time')->nullable();
            $table->timestamp('created_at', 6);
            $table->timestamp('updated_at', 6);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_trackers');
    }
};
