<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\LeaveSettingFormRequest;
use Inertia\Response;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\LeaveSettings;
use Illuminate\Http\JsonResponse;

class LeaveController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('setting/leave/Index' , [
            'page_name' => 'Leave Setting',
        ]);
    }

    public function allLeaves(): JsonResponse
    {
        $leaves = LeaveSettings::all();

        return response()->json([
            'message' => "data fetched.",
            'leaves' => $leaves, 
        ]);
    }

    public function update(LeaveSettingFormRequest $request): JsonResponse
    {
        foreach ($request->all() as $leave) {

            $leave_obj = LeaveSettings::find($leave['id']);
            $details = $leave['details'];

            if (array_key_exists('is_carry_forward', $details)) {
                $details['is_carry_forward'] = $details['is_carry_forward'] ? 1 : 0;
            }

            if (array_key_exists('one_time_in_organization', $details)) {
                $details['one_time_in_organization'] = $details['one_time_in_organization'] ? 1 : 0;
            }

            $leave_obj->fill([
                'details' => $details
            ])->save();
        }

        return response()->json([
            'message' => "Leaves update successfully.",
        ]);
    }
}
