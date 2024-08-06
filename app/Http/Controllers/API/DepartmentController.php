<?php

namespace App\Http\Controllers\API;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DepartmentResource;
use App\Http\Controllers\API\BaseController;

class DepartmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        return $this->successResponse(DepartmentResource::collection($departments), 'Departments retrieved successfully.');
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
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $department = Department::create([
            'name' => $input['name'],
        ]);

        return $this->successResponse(new DepartmentResource($department), 'Department created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::find($id);

        if (is_null($department)) {
            return $this->errorResponse('Department not found.', [], 404);
        }

        return $this->successResponse(new DepartmentResource($department), 'Department retrieved successfully.');
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
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $department = Department::find($id);

        if (is_null($department)) {
            return $this->errorResponse('Department not found.', [], 404);
        }

        $department->name = $input['name'];
        $department->save();

        return $this->successResponse(new DepartmentResource($department), 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::find($id);

        if (is_null($department)) {
            return $this->errorResponse('Department not found.', [], 404);
        }

        $department->delete();

        return $this->successResponse([], 'Department deleted successfully.');
    }
}
