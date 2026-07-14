<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('device_users', function (Blueprint $table) {
            $table->id();
            $table->string('sn')->nullable();
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('privilege')->nullable();
            $table->string('password')->nullable();
            $table->string('card')->nullable();
            $table->string('group_id')->nullable();
            $table->text('raw_data')->nullable();
            $table->timestamps();

            $table->unique(['sn', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_users');
    }
}
