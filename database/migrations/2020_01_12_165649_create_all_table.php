<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('username', 20)->unique();
            $table->char('password', 255);
            $table->char('display_name', 240)->nullable();
            $table->char('email', 240)->unique();
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('selected_assignment_id')->nullable();
            $table->rememberToken();
            $table->dateTime('first_login_time')->nullable();
            $table->dateTime('last_login_time')->nullable();
            $table->timestamps();
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->Increments('id');
            $table->char('name', 50);
        });
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 45);
            $table->char('extension', 8);
            $table->unsignedInteger('default_time_limit');
            $table->unsignedInteger('default_memory_limit');
            $table->unsignedInteger('sorting');  
            $table->timestamps();
        });
        Schema::create('problems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 150);
            $table->tinyInteger('allow_practice');
            $table->char('diff_cmd', 20);
            $table->char('diff_arg', 20);
            $table->text('admin_note')->nullable();
            $table->tinyInteger('difficult')->nullable();
            $table->bigInteger('elo')->nullable();
            $table->timestamps();
        });
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('key', 50)->unique();
            $table->text('value');
            $table->timestamps();
        });
        Schema::create('queue_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('submission_id');
            $table->char('type', 8);
            $table->unsignedInteger('processid')->nullable();
            $table->timestamps();
        });
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->char('name', 150);
            $table->unsignedInteger('total_submits')->default(0);
            $table->boolean('open');
            $table->boolean('score_board');
            $table->dateTime('start_time');
            $table->dateTime('finish_time');
            $table->integer('extra_time');
            $table->text('late_rule')->nullable();
            $table->text('description')->nullable(); 
            $table->char('moss_update', 30)->nullable();
            $table->timestamps();
        });
        Schema::create('assignment_problem', function (Blueprint $table) {
            $table->unsignedBigInteger('assignment_id');
            $table->unsignedBigInteger('problem_id');
            $table->integer('score');
            $table->integer('ordering');
            $table->char('problem_name', 150);
            $table->timestamps();
        });
        Schema::create('submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('assignment_id');
            $table->unsignedBigInteger('problem_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('is_final');
            $table->char('status',100);
            $table->integer('pre_score');
            $table->char('coefficient',6);
            $table->char('file_name',30);
            $table->unsignedBigInteger('language_id');
            $table->timestamps();
        });
        Schema::create('language_problem', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('problem_id');
            $table->unsignedInteger('time_limit');
            $table->unsignedInteger('memory_limit');
            $table->timestamps();
        });
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('title',200);
            $table->text('text');
            $table->text('description');
            $table->unsignedInteger('author');
            $table->unsignedInteger('last_author');
            $table->timestamps();
        });

        Schema::create('scoreboards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedSmallInteger('assignment_id'); 
            $table->longText('scoreboard'); 
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('problems');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('queue');
        Schema::dropIfExists('queue_items');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('assignment_problem');
        Schema::dropIfExists('problem_assignment');
        Schema::dropIfExists('submissions');
        Schema::dropIfExists('language_problem');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('scoreboards');
    }
}
