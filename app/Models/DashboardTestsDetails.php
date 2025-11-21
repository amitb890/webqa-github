<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardTestsDetails extends Model
{
    use HasFactory;
    protected $table = 'dashboard_tests_details';
    protected $fillable = ['id', 'dashboard_test_id', 'url', 'data', 'status', 'error_message'];

    public function dashboardTest()
    {
        return $this->belongsTo(DashboardTests::class);
    }
}
