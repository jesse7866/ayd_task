<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loggers', function (Blueprint $table) {
            $table->id();
            $table->longText('message');
            $table->string('channel')->index();
            $table->string('level')->index();
            $table->string('level_name');
            $table->longText('context')->nullable();
            $table->longText('extra')->nullable();
            $table->longText('formatted');
            $table->string('remote_addr')->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loggers');
    }
};
