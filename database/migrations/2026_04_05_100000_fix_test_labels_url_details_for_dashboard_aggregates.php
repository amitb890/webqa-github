<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Dashboard POSTs use /test-details/security-headers and /test-details/coding-best-practices
     * for grouped tiles — not per-tool paths (those return 404).
     */
    public function up(): void
    {
        DB::table('test_labels')
            ->where('parent', 'security')
            ->where('dashboard_parent', 'security_labels')
            ->update(['urlDetails' => '/test-details/security-headers']);

        DB::table('test_labels')
            ->where('parent', 'bestPractices')
            ->where('dashboard_parent', 'cbp_labels')
            ->update(['urlDetails' => '/test-details/coding-best-practices']);
    }

    public function down(): void
    {
        // Non-reversible; previous values were inconsistent.
    }
};
