<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    public function run(): void
    {
        Holiday::truncate();

        $holidays = [
            // Holidays for 2023
            [
                'title' => 'Republic Day',
                'date' => '2023-01-26',
                'day' => 26,
                'month' => 1,
                'year' => 2023,
            ],
            [
                'title' => 'Holi',
                'date' => '2023-03-08',
                'day' => 8,
                'month' => 3,
                'year' => 2023,
            ],
            [
                'title' => 'Independence Day',
                'date' => '2023-08-15',
                'day' => 15,
                'month' => 8,
                'year' => 2023,
            ],
            [
                'title' => 'Diwali',
                'date' => '2023-11-12',
                'day' => 12,
                'month' => 11,
                'year' => 2023,
            ],
            [
                'title' => 'Christmas',
                'date' => '2023-12-25',
                'day' => 25,
                'month' => 12,
                'year' => 2023,
            ],
        
            // Holidays for 2024
            [
                'title' => 'Republic Day',
                'date' => '2024-01-26',
                'day' => 26,
                'month' => 1,
                'year' => 2024,
            ],
            [
                'title' => 'Holi',
                'date' => '2024-03-25',
                'day' => 25,
                'month' => 3,
                'year' => 2024,
            ],
            [
                'title' => 'Independence Day',
                'date' => '2024-08-15',
                'day' => 15,
                'month' => 8,
                'year' => 2024,
            ],
            [
                'title' => 'Diwali',
                'date' => '2024-11-01',
                'day' => 1,
                'month' => 11,
                'year' => 2024,
            ],
            [
                'title' => 'Christmas',
                'date' => '2024-12-25',
                'day' => 25,
                'month' => 12,
                'year' => 2024,
            ],
        
            // Holidays for 2025
            [
                'title' => 'Republic Day',
                'date' => '2025-01-26',
                'day' => 26,
                'month' => 1,
                'year' => 2025,
            ],
            [
                'title' => 'Holi',
                'date' => '2025-03-14',
                'day' => 14,
                'month' => 3,
                'year' => 2025,
            ],
            [
                'title' => 'Independence Day',
                'date' => '2025-08-15',
                'day' => 15,
                'month' => 8,
                'year' => 2025,
            ],
            [
                'title' => 'Diwali',
                'date' => '2025-10-21',
                'day' => 21,
                'month' => 10,
                'year' => 2025,
            ],
            [
                'title' => 'Christmas',
                'date' => '2025-12-25',
                'day' => 25,
                'month' => 12,
                'year' => 2025,
            ],
        ];
        
        foreach ($holidays as $holiday) {
            Holiday::create([
                'created_by' => 1,
                'title' => $holiday['title'],
                'date' => $holiday['date'],
                'day' => $holiday['day'],
                'month' => $holiday['month'],
                'year' => $holiday['year'],
            ]);
        }
    }
}
