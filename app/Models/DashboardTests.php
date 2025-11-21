<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardTests extends Model
{
    use HasFactory;
    protected $table = 'dashboard_tests';
    protected $fillable = ['user_id', 'project_id', 'test_id', 'urls', 'status', 'results'];

    public function dashboardTestsDetails()
    {
        return $this->hasMany(DashboardTestsDetails::class);
    }
}
