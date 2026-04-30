<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TimeManagement\Models\User;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("categories", function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class, "user_id")->constrained()->cascadeOnDelete();
            $table->string("title");
            $table->string("color", 20)->nullable();
            $table->timestamps();
            $table->unique(["user_id", "title"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("categories");
    }
};
