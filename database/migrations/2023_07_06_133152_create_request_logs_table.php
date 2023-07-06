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
        Schema::create('request_logs', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->index();
            $table->string('path')->index();
            $table->string('method');
            $table->text('query')->nullable();
            $table->longText('request_body')->nullable();
            $table->longText('response_body')->nullable();
            $table->string('ip');
            $table->string('url');
            $table->text('headers');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_logs');
    }
};
