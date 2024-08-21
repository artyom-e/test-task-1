<?php

namespace Feature\Api;

use App\Http\Controllers\Api\SubmissionController;
use App\Jobs\StoreSubmission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

#[CoversClass(SubmissionController::class)]
class SubmissionControllerTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
        Event::fake();
    }

    #[DataProvider('validationErrorsProvider')]
    public function testValidationErrors(array $payload, array $invalidFields): void
    {
        $response = $this->post(route('api.submit'), $payload, [
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(422);
        if (!empty($invalidFields)) {
            $response->assertJsonValidationErrors($invalidFields);
        }
        Queue::assertNothingPushed();
    }

    #[DataProvider('validationSuccessProvider')]
    public function testValidationSuccess(array $payload): void
    {
        Queue::assertNothingPushed();
        $this->post(route('api.submit'), $payload, [
            'Accept' => 'application/json',
        ])->assertSuccessful();
        Queue::assertPushed(StoreSubmission::class);
    }

    public static function validationErrorsProvider(): array
    {
        return [
            [
                [],
                ['name', 'email', 'message'],
            ],
            [
                ['name' => Str::random(2)],
                ['name'],
            ],
            [
                ['name' => Str::random(256)],
                ['name'],
            ],
            [
                ['email' => 'invalid_email'],
                ['email'],
            ],
            [
                ['message' => Str::random(2)],
                ['message'],
            ],
            [
                ['message' => Str::random(1025)],
                ['message'],
            ],
        ];
    }

    public static function validationSuccessProvider(): array
    {
        $email = 'test@example.com';

        return [
            [
                [
                    'name' => Str::random(3),
                    'email' => $email,
                    'message' => Str::random(3),
                ],
                [
                    'name' => Str::random(255),
                    'email' => $email,
                    'message' => Str::random(1024),
                ],
            ],
        ];
    }
}
