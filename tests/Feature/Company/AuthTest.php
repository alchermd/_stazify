<?php

namespace Tests\Feature\Company;

use App\Models\Industry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_is_logged_in_after_registration()
    {
        $this->followingRedirects();
        $avatar = UploadedFile::fake()->image('avatar.jpg');
        $itAndSoftware = Industry::where('name', 'IT and Software')->first();

        $response = $this->post('/register/company', [
            'account_type' => 2,
            'email' => 'hr@acme.io',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'company_name' => 'ACME Web Services',
            'address' => "185 Foo Street\nSomewhereville, CA",
            'about' => 'We offer software solutions for your business needs!',
            'website' => 'https://acme.io/',
            'avatar' => $avatar,
            'contact_number' => '123456789',
            'industry_id' => $itAndSoftware->id,
        ]);

        // Update: email verification is required first!
        $response->assertSee('Verify Your Email Address');

        // TODO: Find a way to assert the URL as well!
    }

    /** @test */
    public function a_valid_industry_id_should_be_provided_for_registration()
    {
        $response = $this->json('post', '/register/company', [
            'account_type' => 2,
            'email' => 'hr@acme.io',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'company_name' => 'ACME Web Services',
            'address' => "185 Foo Street\nSomewhereville, CA",
            'about' => "We're a company!",
            'contact_number' => '123456789',
            'industry_id' => -1,
        ]);

        $response->assertStatus(422);
        $this->assertArrayHasKey('industry_id', $response->decodeResponseJson()['errors']);
    }

    /** @test */
    public function it_can_login()
    {
        $company = factory(User::class)->state('company')->create();

        $this->post('/login', [
            'email' => $company->email,
            'password' => 'secret',
        ])->assertRedirect('/home');

        // TODO: Find a way to assert the text "Company Dashboard" as well!
    }

    /** @test */
    public function it_cannot_visit_the_registration_pages_once_logged_in()
    {
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($company)
            ->get('/register/company')
            ->assertRedirect('/home');

        $this->actingAs($company)
            ->get('/register/student')
            ->assertRedirect('/home');
    }

    /** @test */
    public function it_cannot_visit_the_password_reset_page_once_logged_in()
    {
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($company)
            ->get('/password/reset')
            ->assertRedirect('/home');
    }

    /** @test */
    public function it_is_greeted_with_a_message_upon_logging_in()
    {
        $company = factory(User::class)->state('company')->create();

        $this->followingRedirects()
            ->post('/login', [
                'email' => $company->email,
                'password' => 'secret',
            ])
            ->assertSee('Welcome back, '.$company->company_name.'!');
    }
}
