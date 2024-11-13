<?php

namespace App\Http\Controllers\Employee;

use App\Http\Requests\EmployeeFormRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\DesignationDetails;
use App\Models\EmployeeAddressDetails;
use App\Models\EmployeeDocumentsDetails;
use App\Models\EmployeeEducationDetails;
use App\Models\EmployeeExperienceDetails;

class EmployeeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('employee/Index',[
            'roles' => Role::all(),
            'page_name' => 'Employees',
        ]);
    }

    public function profile(): Response
    {
        $user = User::with([
            'designation',
            'roles',
            'address',
            'educations',
            'experiences',
            'documents',
        ])->where('id',Auth::user()->id)->first();

        return Inertia::render('employee/profile/Index', [
            'user_details' => $user,
            'page_name' => 'Profile',
        ]);
    }

    public function employee(User $employee): Response
    {
        $user = $employee->load([
            'designation',
            'roles',
            'address',
            'educations',
            'experiences',
            'documents',
        ]);

        return Inertia::render('employee/profile/Index', [
            'user_details' => $user,
            'page_name' => 'Profile',
        ]);
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            $search = $request->search;
            $perPage = $request->per_page ?? 10;
            $page = $request->page ?? 1;

            $query = User::with(['roles','designation']);

            if ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
                $query->orWhere('last_name', 'like', '%' . $search . '%');
                $query->where('email', 'like', '%' . $search . '%');
            }

            $total = $query->count(); 
            $offset = ($page - 1) * $perPage;

            $users = $query->offset($offset)
                ->limit($perPage)
                ->get();

            $total_pages = ceil($total / $perPage);

            $startIndex = ($page - 1) * $perPage;
            $endIndex = min($startIndex + $perPage, $total);

            return $this->successResponse(message: "Users details fetch.", data: [
                'users' => $users,
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

    public function form(User $employee) : Response
    {
        if($employee->exists) {
            $employee->load('address');
            $employee->load('educations');
            $employee->load('experiences');
            $employee->load('documents');
            $employee->load('roles');

            if(count($employee->educations) > 0) {
                foreach ($employee->educations as $index => $education) {
                    $employee->educations[$index]['is_pursuing'] = $education->is_pursuing == 1 ? true : false;
                }
            }
        }

        return Inertia::render('employee/Form',[
            'employee' => $employee->exists ? $employee : null,
            'page_name' => $employee->exists ? 'Update Employee' : 'Create Employee',
            'roles' => Role::all(),
            'designations' => DesignationDetails::all(),
        ]);
    }

    public function createOrUpdate(User $employee, EmployeeFormRequest $request,  UserService $userService): JsonResponse
    {
        try {
            DB::beginTransaction();

            if($request->deleted_education_ids) {
                EmployeeEducationDetails::whereIn('id', explode(',', $request->deleted_education_ids))->delete();
            }

            if($request->deleted_experience_ids) {
                EmployeeExperienceDetails::whereIn('id', explode(',', $request->deleted_experience_ids))->delete();
            }

            if($request->deleted_document_ids) {

                foreach (explode(',', $request->deleted_document_ids) as $document_id) {
                    $document_obj = EmployeeDocumentsDetails::find($document_id);
                    Storage::disk('public')->delete($document_obj->document_file_path);
                    $document_obj->delete();
                }
            }

            $basic_details_fields = $request->basic_details();
            $basic_details_fields['profile_path'] = $employee->exists ? $employee->profile_path : '';

            $employee->fill($basic_details_fields)->save();
            $employee->assignRole(Role::find($request->basic_details['role_id']));

            if (isset($request->basic_details['profile_image'])) {
                $userService->storeProfileImage($request->basic_details['profile_image'], $employee);
            }

            $address_details_fields = $request->address_details();
            $address_details_fields['employee_id'] = $employee->id;
            
            $address_detail = EmployeeAddressDetails::where('employee_id', $employee->id)->first() ?? new EmployeeAddressDetails();

            $address_detail->fill($address_details_fields)->save();

            foreach ($request->educations ?? [] as $education) {

                $education_detail = EmployeeEducationDetails::where('id', $education['id'])->first() ?? new EmployeeEducationDetails();

                $education_detail->fill([
                    'employee_id' => $employee->id,
                    'degree_name' => $education['degree_name'],
                    'university_name' => $education['university_name'],
                    'starting_year' => $education['starting_year'],
                    'ending_year' => $education['ending_year'],
                    'is_pursuing' => $education['is_pursuing'],
                ])->save();
            }

            foreach ($request->experiences ?? [] as $experience) {

                $experience_detail = EmployeeExperienceDetails::where('id', $experience['id'])->first() ?? new EmployeeExperienceDetails();

                $experience_detail->fill([
                    'employee_id' => $employee->id,
                    'job_title' => $experience['job_title'],
                    'joining_date' => $experience['joining_date'],
                    'leaving_date' => $experience['leaving_date'],
                    'job_description' => $experience['job_description'],
                ])->save();
            }

            foreach ($request->documents ?? [] as $document) {
                $userService->doucumentStore($document['file'] , $document['type'] , $employee->id);
            }

            DB::commit();

            return $this->successResponse(message: "{$employee->name} has been {$request->action()} successfully.");
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse(message: $exception->getMessage());
        }
    }

    public function delete(User $user): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            Storage::disk('public')->delete("/uploads/employees/{$user->id}");

            $user->delete();

            DB::commit();

            return $this->successResponse(message: "{$user->name} user has been deleted successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
