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
            $table->increments('id');
            $table->boolean('type')->unsigned()->comment('1:admin 2:user');
            $table->string('last_name', 255);
            $table->string('first_name', 255);
            $table->string('last_name_kana', 255)->nullable();
            $table->string('first_name_kana', 255)->nullable();
            $table->integer('gender')->unsigned()->comment('1:男性 2:女性 3:その他')->nullable();
            $table->string('mobile', 20)->comment('電話番号')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('password', 255);
            $table->string('postal_code', 10)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->integer('status')->unsigned()->comment('1:登録中 2:登録済み');
            $table->softDeletes();
            $table->timestamps();
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
