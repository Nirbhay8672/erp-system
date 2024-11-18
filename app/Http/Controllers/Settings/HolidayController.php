<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\HolidayDetailFormRequest;
use App\Models\Holiday;
use Inertia\Response;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HolidayController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('holiday/Index' , [
            'page_name' => 'Holidays',
        ]);
    }

    public function holidayList(): JsonResponse
    {
        $holidays_years = Holiday::select(
            DB::raw("(DATE_FORMAT(date, '%Y')) as year")
        )->distinct()->orderBy('year', 'asc')->get();

        return response()->json([
            'holidays_year' => $holidays_years,
        ]);
    }

    public function yearFilter(Request $request): JsonResponse
    {
        $holiday_data = Holiday::select(
            'id',
            'title',
            'date',
            'day',
            'month',
            'year',
            DB::raw("(DATE_FORMAT(date, '%d/%m/%Y')) as date_format"),
            DB::raw('CONCAT(MONTHNAME(date)) as month_name'),
            DB::raw("(DAYNAME(date)) as day_name")
        )->where('year', $request->year_filter)->orderBy('date_format', 'asc')->get();

        $grouped_data = $holiday_data->groupBy("month_name");

        return response()->json([
            'holiday_list' => $grouped_data
        ]);
    }

    public function getHoliday(Request $request): JsonResponse
    {
        $filter_with_year = $request->year_filter ?? Carbon::now()->format('Y');

        $holiday_list = Holiday::whereYear('date', $filter_with_year)
            ->select([
                'id',
                'title',
                'day',
                'month',
                DB::raw("DATE_FORMAT(date, '%d/%m/%Y') AS date"),
            ])
            ->orderBy("month")
            ->orderBy("day")
            ->get();

        return $this->jsonResponse(
            'Holiday list fetch',
            [
                'holiday_list' => $holiday_list
            ]
        );
    }

    public function updateHoliday(HolidayDetailFormRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->updateHolidays();

            $request->revokeHoliDays();

            DB::commit();

            return response()->json([
                'message' => 'Holiday details has been updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
