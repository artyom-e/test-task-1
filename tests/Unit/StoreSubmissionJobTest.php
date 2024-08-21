<?php

namespace Tests\Unit;

use App\Data\SubmissionData;
use App\Events\SubmissionSaved;
use App\Jobs\StoreSubmission;
use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(StoreSubmission::class)]
class StoreSubmissionJobTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private function dispatchJob(): void
    {
        dispatch_sync(new StoreSubmission(new SubmissionData(
            name: $this->faker->name(),
            email: $this->faker->email(),
            message: $this->faker->sentence(),
        )));
    }

    public function testSubmissionStoredToDb(): void
    {
        $this->assertTrue(Submission::count() === 0);
        $this->dispatchJob();
        $this->assertTrue(Submission::count() === 1);
    }

    public function testEventDispatched(): void
    {
        Event::fake();
        $this->dispatchJob();
        Event::assertDispatched(SubmissionSaved::class);
    }
}
