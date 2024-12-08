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
                    'add_leave_per_month' => 0.75,
                    'is_carry_forward' => 0,
                ],
            ],
            [
                'leave_type' => 'Earned Leave',
                'leave_type_slug' => 'earned_leave',
                'details' => [
                    'total_leave_per_year' => 15,
                    'max_accumulated_leaves' => 30,
                    'add_leave_per_month' => 1.25,
                    'is_carry_forward' => 1,
                ],
            ],
            [
                'leave_type' => 'Sick Leave',
                'leave_type_slug' => 'sick_leave',
                'details' => [
                    'total_leave_per_year' => 9,
                    'add_leave_per_month' => 0.75,
                    'is_carry_forward' => 0,
                ],
            ],
            [
                'leave_type' => 'Maternity Leave',
                'leave_type_slug' => 'maternity_leave',
                'details' => [
                    'paid_leaves' => 84,
                    'one_time_in_organization' => 1,
                ],
            ],
            [
                'leave_type' => 'Paternity Leave',
                'leave_type_slug' => 'paternity_leave',
                'details' => [
                    'paid_leaves' => 5,
                    'one_time_in_organization' => 1,
                ],
            ],
            [
                'leave_type' => 'Marriage Leave',
                'leave_type_slug' => 'marriage_leave',
                'details' => [
                    'paid_leaves' => 5,
                    'max_allowed_leaves' => 15,
                    'one_time_in_organization' => 1,
                ],
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
