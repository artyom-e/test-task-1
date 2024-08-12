<?php

namespace App\Jobs;

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
    public function __construct(private array $submissionData)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $submission = Submission::create($this->submissionData);
        SubmissionSaved::dispatch($submission);
    }
}
