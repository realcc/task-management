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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Seed some example projects
        $this->seedProjects();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }

    /**
     * Seed example projects.
     *
     * @return void
     */
    private function seedProjects()
    {
        \DB::table('projects')->insert([
            ['name' => 'Project A', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Project B', 'created_at' => now(), 'updated_at' => now()],
            // Add more projects as needed
        ]);
    }
};
