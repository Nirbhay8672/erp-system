<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AttendanceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('attendance/Index' , [
            'page_name' => 'Attendance',
        ]);
    }

    public function dataTable(Request $request): JsonResponse
    {
        try {
            $perPage = $request->per_page ?? 10;
            $page = $request->page ?? 1;

            $filterData = $request->filterData;

            $from_date = $filterData['from_date'] ? Carbon::createFromFormat('d/m/Y', $filterData['from_date'])->format('Y-m-d') : Carbon::now();
            $to_date = $filterData['to_date'] ? Carbon::createFromFormat('d/m/Y', $filterData['to_date'])->format('Y-m-d') : Carbon::now();

            $query = DB::table('employee_attendance_details');

            if ($from_date && $to_date) {
                $query->whereDate('attendance_date', '>=', $from_date);
                $query->whereDate('attendance_date', '<=', $to_date);
            }

            $query->groupBy('id');

            $query->select([
                DB::raw("DATE_FORMAT(attendance_date, '%d/%m/%Y') as date"),
                DB::raw("TIME_FORMAT(time_in, '%h:%i %p') as punch_in_formatted"),
                DB::raw("TIME_FORMAT(time_out, '%h:%i %p') as punch_out_formatted"),
                DB::raw("TIME_FORMAT(time_in, '%H:%i') as punch_in"),
                DB::raw("TIME_FORMAT(time_out, '%H:%i') as punch_out"),
                DB::raw("SUM(time_different) as total_time"),
            ])
            ->where('employee_id', Auth::user()->id);

            $total = $query->count(); 
            $offset = ($page - 1) * $perPage;

            $attendances = $query->offset($offset)
                ->limit($perPage)
                ->get();

            $attendanceService = new AttendanceService();

            $new_data_array = [];
            foreach ($attendances as $attendance) {
                $attendance->total_hours = $attendance->punch_out_formatted ? $attendanceService->convertMinutesToHoursAndMinutes($attendance->total_time) : '-';
                $attendance->punch_out_formatted = $attendance->punch_out_formatted ?? '-';
                array_push($new_data_array, $attendance);
            }

            $total_pages = ceil($total / $perPage);

            $startIndex = ($page - 1) * $perPage;
            $endIndex = min($startIndex + $perPage, $total);

            return $this->successResponse(message: "Users details fetch.", data: [
                'attendances' => $new_data_array,
                'total' => $total,
                'total_pages' => $total_pages,
                'start_index' => $startIndex + 1,
                'end_index' => $endIndex,
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse(message: $exception->getMessage());
        }
    }

    public function summary(AttendanceService $attendanceService, Request $request): JsonResponse
    {
        try {
            $attendanceData = $attendanceService->getSummary($request->date);

            $attendanceData['working_hours'] = $attendanceService->convertMinutesToHoursAndMinutes($attendanceData['total_minutes']);

            return $this->successResponse(message: "Attendance details fetch.", data: [
                'attendance_data' => $attendanceData,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function details(AttendanceService $attendanceService, Request $request): JsonResponse
    {
        try {
            $attendanceData = $attendanceService->attendance($request->date, intval(Auth::user()->id));

            return $this->successResponse(message: "Attendance details fetch.", data: [
                'attendance_data' => $attendanceData,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function punchIn(AttendanceService $attendanceService): JsonResponse
    {
        try {
            DB::beginTransaction();

            $lastEntry = $attendanceService->lastEntry();

            if ($lastEntry && is_null($lastEntry->time_out)) {
                return $this->jsonResponse(
                    message: "Already punch in.",
                    status: 422
                );
            }

            $attendanceService->storeAttendance([
                'employee_id' => Auth::user()->id,
                'attendance_date' => Carbon::now(),
                'time_in' => Carbon::now()->format('H:i')
            ]);

            DB::commit();

            return $this->successResponse(message: "Punch In Successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function punchOut(AttendanceService $attendanceService): JsonResponse
    {
        try {
            DB::beginTransaction();

            $lastEntry = $attendanceService->lastEntry();

            $minute_difference = now()->diffInMinutes($lastEntry->time_in);

            $allowed_minute_difference = 5;

            if ($minute_difference < $allowed_minute_difference) {
                return response()->json([
                    'message' => 'You can punch out after 5 minutes of punch in.'
                ], 422);
            }

            if (!is_null($lastEntry->time_out)) {
                return response()->json([
                    'message' => 'Already punch out.'
                ], 422);
            }

            $attendanceService->updateAttendance();

            DB::commit();

            return $this->successResponse(message: "Punch Out Successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
