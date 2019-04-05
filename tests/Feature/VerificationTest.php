<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    /** @test */
    public function a_company_can_send_a_request_for_validation()
    {
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($company)
            ->post(route('company.verify.request', [
                'user' => $company->id
            ]), [
                'message' => 'Please verify our company.',
                'attachment' => UploadedFile::fake()->create('verification.pdf')
            ]);

        $this->assertDatabaseHas('verification_requests', [
            'company_id' => $company->id,
            'message' => 'Please verify our company.',
        ]);
    }

    /** @test */
    public function the_validation_request_creation_page_exists()
    {
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($company)
            ->get(route('company.verify.request.create'))
            ->assertOk();
    }

    /** @test */
    public function only_companies_can_access_the_verification_request_creation_page()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get(route('company.verify.request.create'))
            ->assertStatus(401);
    }
}
