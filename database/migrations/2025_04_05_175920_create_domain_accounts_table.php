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
        Schema::create('domain_accounts', function (Blueprint $table) {
            $table->uuid('guid')->primary();
            $table->string('username')->unique()->nullable();
            $table->string('first_name')->nullable(); // first_name
            $table->string('last_name')->nullable(); // last_name
            $table->string('display_name')->nullable(); // display_name
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('department')->nullable();
            $table->string('email')->nullable(); // email
            $table->string('domain')->nullable();
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domain_accounts');
    }
};
