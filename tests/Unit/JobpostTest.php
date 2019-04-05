<?php

namespace Tests\Unit;

use App\Models\Jobpost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobpostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_jobposts_from_factory()
    {
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $this->assertDatabaseHas('jobposts', $jobpost->toArray());
    }

    /** @test */
    public function it_can_determine_if_it_is_closed()
    {
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $this->assertFalse($jobpost->isClosed());
    }

    /** @test */
    public function it_can_be_closed()
    {
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $jobpost = $jobpost->markAsClosed();

        $this->assertTrue($jobpost->isClosed());
    }
}
