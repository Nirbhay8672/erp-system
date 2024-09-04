<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function dataTable(Request $request): JsonResponse
    {
        try {
            $filterData = $request->filterData;

            $from_date = $filterData['from_date'] ? Carbon::createFromFormat('d/m/Y', $filterData['from_date'])->format('Y-m-d') : Carbon::now();
            $to_date = $filterData['to_date'] ? Carbon::createFromFormat('d/m/Y', $filterData['to_date'])->format('Y-m-d') : Carbon::now();

            $query = DB::table('employee_attendance_details')
                ->where('employee_id', Auth::user()->id);

            if ($from_date && $to_date) {
                $query->whereDate('attendance_date', '>=', $from_date);
                $query->whereDate('attendance_date', '<=', $to_date);
            }

            return response()->json($query->get());
        } catch (\Exception $e) {
            dd($e);
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
