<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TimeManagement\Enums\TaskPriority;
use TimeManagement\Models\User;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("tasks", function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class, "user_id")->constrained()->cascadeOnDelete();
            $table->string("name");
            $table->text("description")->nullable();
            $table->enum("priority", TaskPriority::cases())->default(TaskPriority::MEDIUM);
            $table->timestamp("due_date")->nullable();
            $table->timestamp("completed_at")->nullable();
            $table->timestamps();
            $table->index(["user_id", "priority"]);
            $table->index("due_date");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("tasks");
    }
};
