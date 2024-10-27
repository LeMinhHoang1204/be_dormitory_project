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
            $table->id();
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // expand
            $table->rememberToken();
            $table->timestamps();

            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('role')->default(3);
            $table->string('phone', 50)->nullable();
            $table->string('profile_image_path', 255)->nullable();
            $table->string('bio', 255)->nullable();
        });

        DB::statement('ALTER TABLE users ADD CONSTRAINT check_user_status CHECK (status IN (0, 1))');
        // 0: KHONG CON HOAT DONG, 1: CON HOAT DONG
        DB::statement('ALTER TABLE users ADD CONSTRAINT check_user_type CHECK (role IN (0, 1, 2, 3))');
        // 0: ADMIN, 1: BUILDING MANAGER, 2: ACCOUNTANT, 3: STUDENT

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
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

    public function student()
    {
        return $this->hasOne(Student::class, 'STU_USER_ID'); // assuming 'STU_USER_ID' is the foreign key in 'student' table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
