<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Submission\StoreRequest;
use App\Jobs\StoreSubmission;
use Illuminate\Http\JsonResponse;

class SubmissionController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        StoreSubmission::dispatch($request->validated());

        return response()->json(null, 204);
    }
}
