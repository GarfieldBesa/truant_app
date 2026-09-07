<?php

use App\Models\Employee;
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
        Schema::table('employees', function (Blueprint $table) {
            $table->json('roles')->nullable()->after('role');
        });

        // Migrate existing role data into roles array
        foreach (Employee::all() as $emp) {
            if ($emp->role === 'timesheet_portal') {
                $emp->roles = ['timesheet_portal'];
            } else {
                $emp->roles = [];
            }
            $emp->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('roles');
        });
    }
};
