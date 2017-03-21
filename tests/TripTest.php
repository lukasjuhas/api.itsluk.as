<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class TripsTest extends ApiTester
{
    /** @test */
    public function it_fetches_trips()
    {
        $this->times(5)->make('Trip');

        $this->getJson('trips');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_a_single_trip()
    {
        $this->make('Trip');

        $trip = $this->getJson('trips/iceland?all=1');

        $this->assertResponseOk();
        // $this->assertObjectHasAttributes($trip, 'title');
    }

    /** @test */
    public function it_404s_if_a_trip_is_not_found()
    {
        $json = $this->getJson('trips/x');

        $this->assertResponseStatus(404);
        $this->assertObjectHasAttributes($json, 'error');
    }

    /** @test */
    // public function it_creates_a_new_trip_given_valid_parameters()
    // {
    //     $json = $this->getJson('trips', 'POST', $this->getStub());
    //
    //     $this->assertResponseStatus(201);
    //     $this->assertObjectHasAttributes($json, 'id');
    // }

    /** @test */
    // public function it_throws_a_422_if_a_new_trip_request_fails_validation()
    // {
    //     $this->getJson('trips', 'POST');
    //
    //     $this->assertResponseStatus(422);
    // }

    /**
     * helper get stub
     * @return array
     */
    public function getStub()
    {
        $country = $this->fake->country;

        $withContent = rand(1, 0);

        return [
          'user_id' => 1,
          'name' => $country,
          'slug' => str_slug($country),
          'location' => $country,
          'date_string' => $this->fake->date($format = 'F Y', $max = 'now'),
          'feature' => $withContent ? $this->fake->imageUrl(1200, 500, 'city') : '',
          'content' => $withContent ? $this->fake->text(1000) : '',
          'upcoming' => 0,
          'status' => 'published'
        ];
    }
}
