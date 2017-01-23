<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Dispatch;

class DispatchesTest extends ApiTester
{
    /** @test */
    public function it_fetches_dispatches()
    {
        $this->times(5)->makeDispatch();

        $this->getJson('dispatches');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_a_single_dispatch()
    {
        $this->makeDispatch();

        $dispatch = $this->getJson('dispatches/1')->data;

        $this->assertResponseOk();
        $this->assertObjectHasAttributes($dispatch, 'post_title', 'post_content');
    }

    /** @test */
    public function it_404s_if_a_dispatch_is_not_found()
    {
        $this->getJson('dispatches/x');

        $this->assertResponseStatus(404);
    }

    private function makeDispatch($dispatchFields = [])
    {
        $dispatch = array_merge([
          'title' => $this->fake->sentence,
          'content' => $this->fake->paragraph,
        ], $dispatchFields);

        while ($this->times--) {
            Dispatch::create($dispatch);
        }
    }
}
