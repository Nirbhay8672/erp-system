<?php

namespace Database\Seeders;

use App\Models\LeaveSettings;
use Illuminate\Database\Seeder;

class LeaveSettingsSeeder extends Seeder
{
    public function run(): void
    {
        LeaveSettings::truncate();

        $leaves = [
            [
                'leave_type' => 'Casual Leave',
                'leave_type_slug' => 'casual_leave',
                'details' => [
                    'total_leave_per_year' => 9,
                    'max_leave_per_month' => 3,
                    'add_leave_per_month' => 1,
                    'is_carry_forward' => 1,
                ],
            ],
            [
                'leave_type' => 'Earned Leave',
                'leave_type_slug' => 'earned_leave',
                'details' => [
                    'total_leave_per_year' => 12,
                    'max_accumulated_leaves' => 30,
                    'add_leave_per_month' => 1,
                    'is_carry_forward' => 1,
                ],
            ],
            [
                'leave_type' => 'Sick Leave',
                'leave_type_slug' => 'sick_leave',
                'details' => [
                    'total_leave_per_year' => 4,
                    'add_leave_per_month' => 2,
                    'is_carry_forward' => 1,
                ],
            ],
            [
                'leave_type' => 'Work From Home',
                'leave_type_slug' => 'work_from_home',
                'details' => [
                    'total_leave_per_year' => 12,
                    'add_leave_per_month' => 2,
                    'is_carry_forward' => 1,
                ],
            ],
            [
                'leave_type' => 'Compensatory Off',
                'leave_type_slug' => 'compensatory_off',
                'details' => [],
            ],
            [
                'leave_type' => 'Leave Without Pay',
                'leave_type_slug' => 'leave_without_pay',
                'details' => [],
            ],
        ];

        foreach ($leaves as $index => $leave_fields) {
            LeaveSettings::create([
                'leave_type' => $leave_fields['leave_type'],
                'leave_type_slug' => $leave_fields['leave_type_slug'],
                'leave_type_uniue_id' => $index + 1,
                'details' => $leave_fields['details'],
            ]);
        }
    }
}
