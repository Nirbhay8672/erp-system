<?php

namespace App\Http\Controllers\Employee;

use App\Helper\DataTable\TableBuilder;
use App\Helper\DataTable\TableColumn;
use App\Helper\DataTable\TableRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeFormRequest;
use App\Models\DesignationDetails;
use App\Models\EmployeeBasicDetails;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        $all_designations = DesignationDetails::all();
        $all_roles = Role::all();

        $all_employee = EmployeeBasicDetails::select([
            'id',
                DB::raw('CONCAT(`first_name`," ",`last_name`) AS employee_name')
            ])->get();

        return Inertia::render('employee/Index',[
            'employees' => $all_employee,
            'all_roles' => $all_roles,
            'all_designations' => $all_designations,
            'user' => Auth::user(),
            'url' => url('/')
        ]);
    }

    public function fetchRecord(TableRequest $request): JsonResponse
    {
        $query = DB::table('users')
            ->select([
                'users.id',
                'employee_basic_details.employee_number',
                'employee_basic_details.contact_number',
                'users.email_address',
                'designation_details.name AS designation_name',
                'roles.slug AS role_name',
                DB::raw('CONCAT(`employee_basic_details`.`first_name`," ",`employee_basic_details`.`last_name`) AS employee_name'),
                DB::raw('CONCAT(`reporting_person`.`first_name`," ",`reporting_person`.`last_name`) AS reporting_person')
            ])
            ->join('employee_basic_details','users.employee_id','=','employee_basic_details.id')
            ->leftJoin("employee_basic_details as reporting_person", 'reporting_person.id', '=', 'employee_basic_details.reporting_to')
            ->join('designation_details','employee_basic_details.designation_id','=','designation_details.id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id');

        if(Auth::user()->hasRole('employee')){
            $query->whereHas(
                'roles', function($q){
                    $q->where('name','!=', 'admin');
                });
        }

        // $tableBuilder = TableBuilder::build($query)
        //     ->setGroupBy('users.id')
        //     ->setRequest($request)
        //     ->addColumn(TableColumn::select(as: 'id', field: 'users.employee_id'))
        //     ->addColumn(TableColumn::select(as: 'employee_name', field: DB::raw('CONCAT(`employee_basic_details`.`first_name`," ",`employee_basic_details`.`last_name`)')))
        //     ->addColumn(TableColumn::select(as: 'employee_number', field: 'employee_basic_details.	employee_number'))
        //     ->addColumn(TableColumn::select(as: 'email_address', field: 'users.email_address'))
        //     ->addColumn(TableColumn::select(as: 'contact_number', field: 'employee_basic_details.contact_number'))
        //     ->addColumn(TableColumn::select(as: 'designation_name', field: 'designation_details.name'))
        //     ->addColumn(TableColumn::select(as: 'role_name', field: 'roles.slug'))
        //     ->addColumn(TableColumn::select(as: 'reporting_person', field: DB::raw('CONCAT(`reporting_person`.`first_name`," ",`reporting_person`.`last_name`)')))
        //     ->fetch();

        return response()->json($query->get());
    }

    public function storeOrUpdate(EmployeeFormRequest $request): JsonResponse
    {
        if($request->employee_id == null)
        {
            $employee = new EmployeeBasicDetails;
            $user = new User;
        }
        else
        {
            $employee = EmployeeBasicDetails::findOrFail((int) $request->employee_id);
            $user = User::findOrFail((int) $request->user_id);
        }

        $employee->fill($request->getBasicDetailsRequestFields())->save();

        $data = $request->getUserDetailsRequestFields();
        $data['employee_id'] = $employee->id;
        $user->fill($data)->save();

        $user->Roles()->detach();
        $user->assignRole($request->role);

        return response()->json([
            'message' => 'Record added or update successfully.'
        ], 200 );
    }

    public function edit($employee_id): JsonResponse
    {
        $employee_details = User::select([
            'users.email_address',
            'users.user_name',
            'users.id as user_id',
            'employee_basic_details.id',
            'employee_basic_details.employee_number',
            'employee_basic_details.reporting_to',
            'employee_basic_details.designation_id',
            'employee_basic_details.first_name',
            'employee_basic_details.last_name',
            'employee_basic_details.gender',
            'employee_basic_details.contact_number',
            'employee_basic_details.date_of_birth',
            'employee_basic_details.joining_date',
        ])
        ->join('employee_basic_details','users.employee_id','=','employee_basic_details.id')
        ->where('employee_id',$employee_id)
        ->with('roles')
        ->first();
        
        return response()->json([
            'message' => 'Record fetch.',
            'data' => [
                'employee_details' => $employee_details
            ]
        ], 200 );
    }
}