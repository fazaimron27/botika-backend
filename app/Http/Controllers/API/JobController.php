<?php

namespace App\Http\Controllers\API;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class JobController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::all();
        return $this->successResponse(JobResource::collection($jobs), 'Jobs retrieved successfully.');
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
            'title' => 'required',
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $job = Job::create([
            'title' => $input['title'],
            'department_id' => $input['department_id'],
        ]);

        return $this->successResponse(new JobResource($job), 'Job created successfully.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::find($id);

        if (is_null($job)) {
            return $this->errorResponse('Job not found.', [], 404);
        }

        return $this->successResponse(new JobResource($job), 'Job retrieved successfully.');
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
            'title' => 'required',
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error', $validator->errors(), 422);
        }

        $job = Job::find($id);

        if (is_null($job)) {
            return $this->errorResponse('Job not found.', [], 404);
        }

        $job->title = $input['title'];
        $job->department_id = $input['department_id'];
        $job->save();

        return $this->successResponse(new JobResource($job), 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::find($id);

        if (is_null($job)) {
            return $this->errorResponse('Job not found.', [], 404);
        }

        $job->delete();

        return $this->successResponse([], 'Job deleted successfully.');
    }
}
