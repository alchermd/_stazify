<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    /** @test */
    public function it_has_a_email_form_is_reflected_on_the_registration_page()
    {
        $this->get('/register/student?email=jdoe@example.com')
            ->assertSee('jdoe@example.com');
    }
}
