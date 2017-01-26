<?php

use Faker\Factory as Faker;

abstract class ApiTester extends TestCase
{
    use Factory;

    /**
     * @var Faker
     */
    protected $fake;

    /**
     * Initialise
     */
    public function __construct()
    {
        $this->fake = Faker::create();
    }

    /**
     * setup databse for each test
     */
    // public function setUp()
    // {
    //     parent::setUp();
    //
    //     $this->app['artisan']->call('migrate');
    // }

    /**
     * Get JSON output
     * @param   string    $uri
     * @param   string    $method
     * @param   array     $parameters
     * @return  mixed
     */
    protected function getJson($uri, $method = 'GET', $parameters = [])
    {
        return  json_decode($this->call($method, $uri, $parameters)->getContent());
    }

    /**
     * Assert object has any number of attributes
     */
    protected function assertObjectHasAttributes()
    {
        $args = func_get_args();
        $object = array_shift($args);

        foreach ($args as $attribute) {
            $this->assertObjectHasAttribute($attribute, $object);
        }
    }
}
