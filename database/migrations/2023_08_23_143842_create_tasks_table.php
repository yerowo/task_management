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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("task_name", 50);
            $table->integer("priority")->default(0);
            $table->unsignedBigInteger('project_id')->nullable();
            $table->enum("status", [1, 0])->default(1);
            $table->timestamps();

            // Add a foreign key constraint
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['project_id']);

            // Drop the project_id column
            $table->dropColumn('project_id');
        });

        Schema::dropIfExists('tasks');
    }
};
