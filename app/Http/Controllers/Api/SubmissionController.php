<?php

namespace App\Http\Controllers\Api;

use App\Data\SubmissionData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Submission\StoreRequest;
use App\Jobs\StoreSubmission;
use Illuminate\Http\JsonResponse;

class SubmissionController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        StoreSubmission::dispatch(SubmissionData::from($request->validated()));

        return response()->json(null, 204);
    }
}
