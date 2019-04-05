<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\VerificationRequest;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    /** @test */
    public function it_can_be_accepted()
    {
        $company = factory(User::class)->state('company')->create();
        $request = factory(VerificationRequest::class)->create([
            'company_id' => $company->id,
        ]);

        $request->accept();

        $this->assertTrue($company->fresh()->isCompanyVerified());
    }
}
