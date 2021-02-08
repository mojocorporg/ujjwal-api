<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('body');
            $table->string('section');
            $table->string('section_id')->nullable();
            $table->string('link')->nullable();
            $table->string('repeat_type')->nullable();
            $table->text('filter_data')->nullable();
            $table->text('days')->nullable();
            $table->time('schedule_time')->nullable();
            $table->date('schedule_date')->nullable();
            $table->text('notification_data')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->unsignedInteger('sent_count')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
