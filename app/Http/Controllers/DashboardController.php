<?php

namespace App\Http\Controllers;

use App\Models\DesignationDetails;
use App\Models\User;
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
        return Inertia::render('Dashboard', [
            'page_name' => 'Dashboard',
            'total_users' => User::all()->count(),
            'total_designations' => DesignationDetails::all()->count(),
            'total_roles' => Role::all()->count(),
        ]);
    }
}
