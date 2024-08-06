<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;


class EmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return $this->successResponse(EmployeeResource::collection($employees), 'Employees retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'phone' => 'required',
            'job_id' => 'required|exists:jobs,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $employee = Employee::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'job_id' => $input['job_id'],
            'status' => $input['status'],
        ]);

        return $this->successResponse(new EmployeeResource($employee), 'Employee created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if (is_null($employee)) {
            return $this->errorResponse('Employee not found.', [], 404);
        }

        return $this->successResponse(new EmployeeResource($employee), 'Employee retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required',
            'job_id' => 'required|exists:jobs,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $employee = Employee::find($id);

        if (is_null($employee)) {
            return $this->errorResponse('Employee not found.', [], 404);
        }

        $employee->name = $input['name'];
        $employee->email = $input['email'];
        $employee->phone = $input['phone'];
        $employee->job_id = $input['job_id'];
        $employee->status = $input['status'];
        $employee->save();

        return $this->successResponse(new EmployeeResource($employee), 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (is_null($employee)) {
            return $this->errorResponse('Employee not found.', [], 404);
        }

        $employee->delete();

        return $this->successResponse([], 'Employee deleted successfully.');
    }
}
