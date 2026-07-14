<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceCommandsTable extends Migration
{
    public function up(): void
    {
        Schema::create('device_commands', function (Blueprint $table) {
            $table->id();
            $table->string('sn');
            $table->text('command');
            $table->boolean('executed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_commands');
    }
}
