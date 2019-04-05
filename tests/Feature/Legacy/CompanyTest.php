<?php

namespace Tests\Feature\Legacy;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_access_the_login_page_even_without_authentication()
    {
        $this->get('/login')
            ->assertStatus(200);
    }

    /** @test */
    public function authenticated_company_is_redirected_to_the_dashboard()
    {
        $user = factory(User::class)->create(['account_type' => '2', 'password' => 'my-password-123']);

        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect('/home');
    }

    /** @test */
    public function visiting_the_registration_page_shows_a_company_registration_link()
    {
        $this->get('/register')
            ->assertStatus(200)
            ->assertSee('Company Registration');
    }

    /** @test */
    public function visiting_the_company_registration_page_shows_appropriate_text()
    {
        $this->get('/register/company')
            ->assertStatus(200)
            ->assertSee('Create a Company Account');
    }

    /** @test */
    public function cant_access_company_registration_page_when_logged_in()
    {
        $company = factory(User::class)->create(['account_type' => 2]);

        $response = $this->actingAs($company)
            ->get('/register/company');

        $response->assertRedirect('/home');
    }

    /** @test */
    public function cant_access_student_registration_page_when_logged_in()
    {
        $company = factory(User::class)->create(['account_type' => 2]);

        $response = $this->actingAs($company)
            ->get('/register/student');

        $response->assertRedirect('/home');
    }

    /** @test */
    public function cant_create_with_invalid_number()
    {
        $companyData = [
            'email' => 'hr@acme.test',
            'password' => 'random-company-password',
            'password_confirmation' => 'random-company-password',
            'account_type' => 2,
            'contact_number' => '1234567890', // 10 digits instead of 9
            'address' => '185 Berry St, San Francisco',
            'company_name' => 'ACME Web Agency',
            'about' => 'We are a web development agency based in California.',
            'website' => 'http://acme-web-agency.com',
            'industry' => 'Information Technology',
            'avatar' => null,
        ];

        $this->post('/register/company', $companyData)
            ->assertSessionHasErrors('contact_number');

        $companyData['contact_number'] = '12345678'; // 8 digits instead of 9

        $this->post('/register/company', $companyData)
            ->assertSessionHasErrors('contact_number');

        $this->assertDatabaseMissing('users', [
            'account_type' => 2,
            'company_name' => 'ACME Web Agency',
        ]);
    }
}
