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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            // M:N 
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();

            $table->foreign('user_id')->references("id")->on("users");
            $table->foreign('role_id')->references("id")->on("roles");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
