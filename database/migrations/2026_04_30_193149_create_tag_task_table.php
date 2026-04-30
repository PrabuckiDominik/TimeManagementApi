<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TimeManagement\Models\Tag;
use TimeManagement\Models\Task;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("tag_task", function (Blueprint $table): void {
            $table->foreignIdFor(Task::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Tag::class)->constrained()->cascadeOnDelete();
            $table->primary(["task_id", "tag_id"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("tag_task");
    }
};
