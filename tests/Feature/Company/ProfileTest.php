<?php

namespace Tests\Feature\Company;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_contains_their_company_information()
    {
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($company)
            ->get('/home/companies/'.$company->id)
            ->assertSee(e($company->company_name))
            ->assertSee($company->email)
            ->assertSee($company->about)
            ->assertSee($company->contact_number)
            ->assertSee($company->address)
            ->assertSee($company->website)
            ->assertSee($company->industry->name)
            ->assertSee('Company Website');
    }

    /** @test */
    public function it_displays_an_edit_button_when_viewed_by_the_owner()
    {
        $company1 = factory(User::class)->state('company')->create();
        $company2 = factory(User::class)->state('company')->create();

        $this->actingAs($company1)
            ->get('/home/companies/'.$company1->id)
            ->assertSee('Edit Profile');

        $this->actingAs($company1)
            ->get('/home/companies/'.$company2->id)
            ->assertDontSee('Edit Profile');
    }

    /** @test */
    public function it_can_edit_their_own_profile()
    {
        $company = factory(User::class)->state('company')->create();
        $avatar = UploadedFile::fake()->image('avatar.png');

        $this->followingRedirects();

        $response = $this->actingAs($company)
            ->put('/home/companies/'.$company->id, [
                'contact_number' => '987654321',
                'address' => 'Our new address',
                'about' => "We're better now!",
                'avatar' => $avatar,
                'company_name' => 'ACME dot IO',
                'website' => 'https://acme.io',
                'industry_id' => 2,
            ]);

        $response->assertSee('ACME dot IO')
            ->assertSee('Customer Service')
            ->assertSee('https://acme.io')
            ->assertSee('Our new address')
            ->assertSee('+639987654321')
            ->assertSee("We're better now!")
            ->assertSee('Company Website')
            ->assertSee('Profile updated!');
    }
}
