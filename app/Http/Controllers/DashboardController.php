<?php

namespace App\Http\Controllers;

use App\Models\DesignationDetails;
use App\Models\Holiday;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Response
    {
        $today = Carbon::today();
        $nextMonth = Carbon::today()->addDays(30);

        $upcomingHolidays = Holiday::whereBetween('date', [$today, $nextMonth])->select([
           'holidays.*',
           DB::raw("(DAYNAME(date)) as day_name") 
        ])->get();

        $upcomingBirthdays = User::whereRaw("
            (
                MONTH(dob) = ? AND DAY(dob) >= ?
            )
            OR
            (
                MONTH(dob) = ? AND DAY(dob) <= ?
            )
        ", [
            $today->month, $today->day,
            $nextMonth->month, $nextMonth->day
        ])->select([
            'dob',
            DB::raw("CONCAT(first_name,' ',last_name) AS employee_name"),
            DB::raw("(DATE_FORMAT(dob, '%d %M')) as date_format"),
            DB::raw("(DAYNAME(dob)) as day_name"),
        ])->get();

        $upcomingBirthdays->each(function (&$birthday) {
            $birthday->is_today = Carbon::parse($birthday->dob)->equalTo(today());
        });

        return Inertia::render('Dashboard', [
            'page_name' => 'Dashboard',
            'total_users' => User::all()->count(),
            'total_designations' => DesignationDetails::all()->count(),
            'total_roles' => Role::all()->count(),
            'upcomingHolidays' => $upcomingHolidays,
            'upcomingBirthDays' => $upcomingBirthdays,
        ]);
    }
}
