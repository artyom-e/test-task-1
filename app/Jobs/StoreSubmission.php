<?php

namespace App\Jobs;

use App\Data\SubmissionData;
use App\Events\SubmissionSaved;
use App\Models\Submission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class StoreSubmission implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private SubmissionData $submissionData)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $submission = Submission::create($this->submissionData->toArray());
        SubmissionSaved::dispatch($submission);
    }
}
