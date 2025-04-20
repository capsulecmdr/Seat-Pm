<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seatpm_tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id'); // Owner / creator

            $table->string('title');
            $table->text('description');

            $table->date('target_start_date')->nullable();
            $table->date('target_completion_date')->nullable();
            $table->decimal('budget_cost', 20, 2)->nullable();

            $table->enum('status', ['Backlog', 'In Progress', 'Blocked', 'Complete'])->default('Backlog');
            $table->unsignedTinyInteger('percent_complete')->default(0);

            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('seatpm_projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['project_id', 'user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seatpm_tasks');
    }
};
