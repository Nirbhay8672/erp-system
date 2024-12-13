<?php

namespace App\Http\Controllers\Employee;

use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeaveRequestFormRequest;
use App\Models\LeaveRequest;
use App\Models\LeaveSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    public $leave_status = [
        1 => [
            'name' => 'Pending',
            'color' => 'bg-gradient-secondary'
        ],
        2 => [
            'name' => 'Approved',
            'color' => 'bg-gradient-success'
        ],
        3 => [
            'name' => 'Declined',
            'color' => 'bg-gradient-danger'
        ],
    ];

    public function index(): Response
    {
        return Inertia::render('leave/Index',[
            'page_name' => 'My Leaves',
            'leave_types' => LeaveSettings::select(['id','leave_type', 'leave_type_slug', 'leave_type_uniue_id'])->get(),
            'leave_status' => $this->leave_status,
        ]);
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            $perPage = $request->per_page ?? 10;
            $page = $request->page ?? 1;
            $status = $request->status;

            $query = LeaveRequest::where('employee_id', Auth::user()->id);
            
            $query->select([
                'employee_leave_requests.*',
                DB::raw("DATE_FORMAT(leave_from, '%d-%m-%Y') as leave_from"),
                DB::raw("DATE_FORMAT(leave_to, '%d-%m-%Y') as leave_to"),
            ]);

            if ($status != "") {
                $query->where('status', $status);
            }

            $total = $query->count(); 
            $offset = ($page - 1) * $perPage;

            $leaveRequests = $query->offset($offset)
                ->limit($perPage)
                ->get();

            $total_pages = ceil($total / $perPage);

            $startIndex = ($page - 1) * $perPage;
            $endIndex = min($startIndex + $perPage, $total);

            return $this->successResponse(message: "leave requests fetch.", data: [
                'leaves' => $leaveRequests,
                'total' => $total,
                'total_pages' => $total_pages,
                'start_index' => $startIndex + 1,
                'end_index' => $endIndex,
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse(message: $exception->getMessage());
        }
    }

    public function addLeave(LeaveRequestFormRequest $request)
    {
        LeaveRequest::create([
            'employee_id' => Auth::user()->id,
            'leave_type' => $request->leave_type,
            'leave_from' => $request->leave_from,
            'leave_to' => $request->leave_to,
            'reason' => $request->reason
        ]);

        return response()->json([
            'message' => "$request->leave_type added successfully.",
        ] , 200 );
    }
    public function employeeLeavesIndex(): Response
    {
        return Inertia::render('employeeLeave/Index',[
            'page_name' => 'Employee Leaves',
            'leave_status' => $this->leave_status,
        ]);
    }

    public function allEmployeeLeaves(Request $request): JsonResponse
    {
        try {
            $perPage = $request->per_page ?? 10;
            $page = $request->page ?? 1;
            $status = $request->status;
            $employee = $request->employee;

            $query = LeaveRequest::with(['employee']);
            
            $query->select([
                'employee_leave_requests.*',
                DB::raw("DATE_FORMAT(leave_from, '%d-%m-%Y') as leave_from"),
                DB::raw("DATE_FORMAT(leave_to, '%d-%m-%Y') as leave_to"),
            ]);

            if ($status != "") {
                $query->where('status', $status);
            }

            if ($employee != "") {
                $query->whereHas('employee', function ($query) use ($employee) {
                    $query->orWhere('name', 'LIKE', "%$employee%");
                    $query->orWhere('first_name', 'LIKE', "%$employee%");
                    $query->orWhere('last_name', 'LIKE', "%$employee%");
                })->get();
            }

            $total = $query->count(); 
            $offset = ($page - 1) * $perPage;

            $leaveRequests = $query->offset($offset)
                ->limit($perPage)
                ->get();

            $total_pages = ceil($total / $perPage);

            $startIndex = ($page - 1) * $perPage;
            $endIndex = min($startIndex + $perPage, $total);

            return $this->successResponse(message: "leave requests fetch.", data: [
                'leaves' => $leaveRequests,
                'total' => $total,
                'total_pages' => $total_pages,
                'start_index' => $startIndex + 1,
                'end_index' => $endIndex,
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse(message: $exception->getMessage());
        }
    }

    public function updateStatus(Request $request)
    {
        LeaveRequest::where('id', $request->id)->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => "Leave status update successfully.",
        ] , 200 );
    }
}
