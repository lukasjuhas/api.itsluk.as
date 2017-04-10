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
            'slug'           => str_slug('Iceland'),
            'location'       => 'Iceland',
            'date_string'    => 'May 2014',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Paris',
            'slug'           => str_slug('Paris'),
            'location'       => 'Paris, France',
            'date_string'    => 'October 2014',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Berlin',
            'slug'           => str_slug('Berlin'),
            'location'       => 'Berlin, Germany',
            'date_string'    => 'October 2014',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Munich',
            'slug'           => str_slug('Munich'),
            'location'       => 'Munich, Germany',
            'date_string'    => 'October 2014',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Germany, High Tatras',
            'slug'           => str_slug('Germany, High Tatras'),
            'location'       => 'Germany, Prague, High Tatras.',
            'date_string'    => 'December 2014, January 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Oslo',
            'slug'           => str_slug('Oslo'),
            'location'       => 'Oslo, Norway',
            'date_string'    => 'February 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Paris',
            'slug'           => str_slug('Paris'),
            'location'       => 'Paris, France',
            'date_string'    => 'March 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Bratislava',
            'slug'           => str_slug('Bratislava'),
            'location'       => 'Bratislava, Slovakia',
            'date_string'    => 'April 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Porto',
            'slug'           => str_slug('Porto'),
            'location'       => 'Porto, Portugal',
            'date_string'    => 'May 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Copenhagen',
            'slug'           => str_slug('Copenhagen'),
            'location'       => 'Copenhagen, Denmark',
            'date_string'    => 'June 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Germany & Switzerland',
            'slug'           => str_slug('Germany & Switzerland'),
            'location'       => 'Ravensburg, Kreuzlingen, Konstanz, Zurich',
            'date_string'    => 'July - August 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Bristol',
            'slug'           => str_slug('Bristol'),
            'location'       => 'Bristol, United Kingdom',
            'date_string'    => 'September 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Amsterdam',
            'slug'           => str_slug('Amsterdam'),
            'location'       => 'Amsterdam, Netherlands',
            'date_string'    => 'October 2015',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'St. Petersburg',
            'slug'           => str_slug('St. Petersburg'),
            'location'       => 'St. Petersburg, Russia',
            'date_string'    => 'December 2015, January 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Marrakesh',
            'slug'           => str_slug('Marrakesh'),
            'location'       => 'Marrakesh, Morocco',
            'date_string'    => 'February 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Venice',
            'slug'           => str_slug('Venice'),
            'location'       => 'Venice, Italy',
            'date_string'    => 'March 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Rye',
            'slug'           => str_slug('Rye'),
            'location'       => 'Rye, United Kingdom',
            'date_string'    => 'March 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Munich',
            'slug'           => str_slug('Munich'),
            'location'       => 'Munich, Germany',
            'date_string'    => 'May 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Crete',
            'slug'           => str_slug('Crete'),
            'location'       => 'Crete, Greece',
            'date_string'    => 'June 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Hamburg',
            'slug'           => str_slug('Hamburg'),
            'location'       => 'Hamburg, Germany',
            'date_string'    => 'June 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'USA',
            'slug'           => str_slug('USA'),
            'location'       => 'East Coast, West Coast, Nashville Tennessee',
            'date_string'    => 'September 2016',
            'feature'        => '',
            'content'        => 'USA',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Bratislava, Prievidza & Bojnice',
            'slug'           => 'bratislava-prievidza-bojnice',
            'location'       => 'Bratislava, Prievidza, Bojnice, Slovakia',
            'date_string'    => 'January 2017',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Bamberg',
            'slug'           => str_slug('Bamberg'),
            'location'       => 'Bamberg, Germany',
            'date_string'    => 'October 2016',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => false,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
            'user_id'        => 1,
            'name'           => 'Paris',
            'slug'           => 'paris-2017',
            'location'       => 'Paris, France',
            'date_string'    => 'April 2017',
            'feature'        => '',
            'content'        => '',
            'upcoming'       => true,
            'status'         => 'published',
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
          'user_id'        => 1,
          'name'           => 'Munich, Heidenheim',
          'slug'           => 'munich-heidenheim',
          'location'       => 'Munich, Heidenheim an der Brenz, Germany',
          'date_string'    => 'May 2017',
          'feature'        => '',
          'content'        => '',
          'upcoming'       => true,
          'status'         => 'published',
          'created_at'     => Carbon::now(),
          'updated_at'     => Carbon::now(),
        ]);

        App\Trip::create([
          'user_id'        => 1,
          'name'           => 'Jersey',
          'slug'           => 'jersey',
          'location'       => 'Jersey, Channel Islands, United Kingdom',
          'date_string'    => 'June 2017',
          'feature'        => '',
          'content'        => '',
          'upcoming'       => true,
          'status'         => 'published',
          'created_at'     => Carbon::now(),
          'updated_at'     => Carbon::now(),
        ]);
    }
}
