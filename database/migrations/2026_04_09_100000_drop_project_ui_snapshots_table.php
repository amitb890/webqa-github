<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('project_ui_snapshots');
    }

    public function down(): void
    {
        // Intentionally empty: snapshots feature removed; do not recreate.
    }
};
