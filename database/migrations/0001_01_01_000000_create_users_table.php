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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('nik', 20)->unique();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('alamat');
            $table->string('telepon');
            $table->string('email')->unique();
            $table->enum('role', ['penanggungJawab', 'kepalaLingkungan', 'admin']);
            $table->enum('status', ['pending', 'approved', 'rejected', 'nonactive'])->default('pending');
            $table->boolean('must_change_password')->default(false);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
