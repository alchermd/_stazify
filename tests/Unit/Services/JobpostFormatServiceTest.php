<?php

namespace Tests\Unit\Services;

use App\Models\Jobpost;
use App\Services\JobpostFormatService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobpostFormatServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var JobpostFormatService
     */
    private $formatter;

    public function setUp()
    {
        parent::setUp();

        $company = factory(User::class)->state('company')->create();

        $qualifications = [
            'Fast learner',
            'Team player',
            'Excellent communication skills',
        ];

        $jobpost = factory(Jobpost::class)->create([
            'user_id' => $company->id,
            'qualifications' => json_encode($qualifications),
        ]);

        $this->formatter = new JobpostFormatService($jobpost);
    }

    /** @test */
    public function it_renders_the_qualifications_correctly()
    {
        $this->expectOutputString("Fast learner\n"."Team player\n"."Excellent communication skills\n");
        $this->formatter->renderQualifications();
    }
}
