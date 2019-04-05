<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_determine_its_name()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $this->assertEquals("{$student->first_name} {$student->last_name}", $student->name);
        $this->assertEquals($company->company_name, $company->name);
    }
}
