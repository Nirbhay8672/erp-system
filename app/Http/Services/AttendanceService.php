<?php

namespace App\Http\Services;

use App\Models\AttendanceDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function attendance($date, int $employee_id = 0)
    {
        try {
            $date_filter = $date ? Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d') : Carbon::today();

            $all_attendance = AttendanceDetails::select([
                DB::raw("TIME_FORMAT(time_in, '%h:%i %p') AS time_in_format"),
                DB::raw("TIME_FORMAT(time_out, '%h:%i %p') AS time_out_format")
            ])->whereDate('attendance_date', $date_filter)
                ->orderBy('id', 'DESC');

            if ($employee_id > 0) {
                $all_attendance->where('employee_id', (int) $employee_id);
            }

            $data = [
                'all_attendance' => $all_attendance->get(),
            ];

            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function getSummary($date)
    {
        try {
            $date_filter = $date ? Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d') : today();

            $last_entry = $this->lastEntry();

            $job_duration = AttendanceDetails::where('employee_id', '=', Auth::user()->id)
                ->whereDate('attendance_date', $date_filter)
                ->sum('time_different');

            $data = [
                'last_entry' => $last_entry,
                'total_minutes' => $job_duration,
            ];

            return $data;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function lastEntry(): AttendanceDetails|null
    {
        try {
            $lastEntry = AttendanceDetails::select([
                'id',
                'time_in',
                'time_out',
                DB::raw("DATE_FORMAT(attendance_date, '%d/%m/%Y') AS date_format"),
                DB::raw("TIME_FORMAT(time_in, '%h:%i %p') AS time_in_format"),
                DB::raw("TIME_FORMAT(time_out, '%h:%i %p') AS time_out_format")
            ])
                ->where('employee_id', '=', Auth::user()->id)
                ->whereDate('attendance_date', Carbon::today())
                ->orderBy('id', 'DESC')
                ->first();

            return $lastEntry;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function storeAttendance(array $punch_in_data)
    {
        try {
            DB::beginTransaction();

            AttendanceDetails::create($punch_in_data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    function convertMinutesToHoursAndMinutes($minutes)
    {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        $result = sprintf('%02d h %02d m', $hours, $remainingMinutes);
        return $result;
    }

    public function updateAttendance(): AttendanceDetails
    {
        try {
            $attendance = AttendanceDetails::where('employee_id', Auth::user()->id)
                ->whereDate('attendance_date', today())
                ->latest()
                ->first();

            $current_time = now();
            $minute_difference = now()->diffInMinutes($attendance->time_in);

            $attendance->fill([
                'time_out' => $current_time,
                'time_different' => $minute_difference
            ])->save();

            return $attendance;
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
