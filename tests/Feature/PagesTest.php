<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_faq_page_exists()
    {
        $this->get('/faq')
            ->assertOk()
            ->assertSee('Frequently Asked Questions');
    }

    /** @test */
    public function a_tos_page_exists()
    {
        $this->get(route('pages.tos'))
            ->assertOk()
            ->assertSee('Terms of Use');
    }
}
