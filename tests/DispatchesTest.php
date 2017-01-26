<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class DispatchesTest extends ApiTester
{
    /** @test */
    public function it_fetches_dispatches()
    {
        $this->times(5)->make('Dispatch');

        $this->getJson('dispatches');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_a_single_dispatch()
    {
        $this->make('Dispatch');

        $dispatch = $this->getJson('dispatches/1')->data;

        $this->assertResponseOk();
        $this->assertObjectHasAttributes($dispatch, 'post_title', 'post_content');
    }

    /** @test */
    public function it_404s_if_a_dispatch_is_not_found()
    {
        $json = $this->getJson('dispatches/x');

        $this->assertResponseStatus(404);
        $this->assertObjectHasAttributes($json, 'error');
    }

    /** @test */
    public function it_creates_a_new_dispatch_given_valid_parameters()
    {
        $json = $this->getJson('dispatches', 'POST', $this->getStub());

        $this->assertResponseStatus(201);
        $this->assertObjectHasAttributes($json, 'id');
    }

    /** @test */
    public function it_throws_a_422_if_a_new_dispatch_request_fails_validation()
    {
        $this->getJson('dispatches', 'POST');

        $this->assertResponseStatus(422);
    }

    protected function getStub()
    {
        return [
          'title' => $this->fake->sentence,
          'content' => $this->fake->paragraph,
        ];
    }
}
