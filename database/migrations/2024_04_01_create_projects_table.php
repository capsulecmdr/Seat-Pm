<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seatpm_projects', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // Owner / creator

            $table->enum('visibility', ['alliance', 'corporation', 'personal']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('target_budget', 20, 2)->nullable(); // ISK/Value
            $table->date('target_completion_date')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['visibility', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seatpm_projects');
    }
};
