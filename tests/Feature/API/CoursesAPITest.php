<?php

namespace Tests\Feature\API;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoursesAPITest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_index_endpoint_returns_all_the_courses()
    {
        $this->artisan('db:seed');

        $response = $this->get(route('api.courses.index'))
            ->json();

        $this->assertEquals(Course::count(), count($response));
    }
}
