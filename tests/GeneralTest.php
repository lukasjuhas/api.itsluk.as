<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class GeneralTest extends ApiTester
{
    /** @test */
    public function it_shows_general_information()
    {
        $this->getJson('/')->data;

        $this->assertResponseOk();
    }
}
