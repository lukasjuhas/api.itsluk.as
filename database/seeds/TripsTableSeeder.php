<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Iceland',
            'location'       => 'Iceland',
            'date_string'    => 'May 2014',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Paris',
            'location'       => 'Paris, France',
            'date_string'    => 'October 2014',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Berlin',
            'location'       => 'Berlin, Germany',
            'date_string'    => 'October 2014',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Munich',
            'location'       => 'Munich, Germany',
            'date_string'    => 'October 2014',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Germany, High Tatras',
            'location'       => 'Germany, Prague, High Tatras.',
            'date_string'    => 'December 2014, January 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Oslo',
            'location'       => 'Oslo, Norway',
            'date_string'    => 'February 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Paris',
            'location'       => 'Paris, France',
            'date_string'    => 'March 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Paris',
            'location'       => 'Paris, France',
            'date_string'    => 'March 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Bratislava',
            'location'       => 'Bratislava, Slovakia',
            'date_string'    => 'April 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Porto',
            'location'       => 'Porto, Portugal',
            'date_string'    => 'May 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Copenhagen',
            'location'       => 'Copenhagen, Denmark',
            'date_string'    => 'June 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Germany & Switzerland',
            'location'       => 'Ravensburg, Kreuzlingen, Konstanz, Zurich',
            'date_string'    => 'July - August 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Bristol',
            'location'       => 'Bristol, United Kingdom',
            'date_string'    => 'September 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Amsterdam',
            'location'       => 'Amsterdam, Netherlands',
            'date_string'    => 'October 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Amsterdam',
            'location'       => 'Amsterdam, Netherlands',
            'date_string'    => 'October 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'St. Petersburg',
            'location'       => 'St. Petersburg, Russia',
            'date_string'    => 'December 2015, January 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Marrakesh',
            'location'       => 'Marrakesh, Morocco',
            'date_string'    => 'February 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Venice',
            'location'       => 'Venice, Italy',
            'date_string'    => 'March 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Rye',
            'location'       => 'Rye, United Kingdom',
            'date_string'    => 'March 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Munich',
            'location'       => 'Munich, Germany',
            'date_string'    => 'May 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Crete',
            'location'       => 'Crete, Greece',
            'date_string'    => 'June 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Hamburg',
            'location'       => 'Hamburg, Germany',
            'date_string'    => 'June 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'USA',
            'location'       => 'New York, California, Nashville',
            'date_string'    => 'September 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Bamberg',
            'location'       => 'Bamberg, Germany',
            'date_string'    => 'October 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);
    }
}
