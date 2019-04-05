<?php

namespace Tests\Feature\API;

use App\Models\Industry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndustriesAPITest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_index_endpoint_returns_all_the_industries()
    {
        $this->artisan('db:seed');

        $response = $this
            ->get(route('api.industries.index'))
            ->json();

        $this->assertEquals(Industry::count(), count($response));
    }
}
