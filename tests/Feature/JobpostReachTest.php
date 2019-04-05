<?php

namespace Tests\Feature;

use App\Models\Jobpost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobpostReachTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function visiting_a_jobpost_will_increase_its_views()
    {
        $company = factory(User::class)->state('company')->create();
        $student = factory(User::class)->state('student')->create();
        $jobpost = factory(Jobpost::class)->create([
            'user_id' => $company->id,
        ]);

        $this->assertEquals(0, $jobpost->views);

        $this->actingAs($student)
            ->get(route('jobposts.show', ['jobpost' => $jobpost->id]));

        $this->assertEquals(1, $jobpost->fresh()->views);
    }

    /** @test */
    public function a_company_visiting_its_own_jobpost_will_not_increase_its_views()
    {
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create([
            'user_id' => $company->id,
        ]);

        $this->assertEquals(0, $jobpost->views);

        $this->actingAs($company)
            ->get(route('jobposts.show', ['jobpost' => $jobpost->id]));

        $this->assertEquals(0, $jobpost->fresh()->views);
    }
}
