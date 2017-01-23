<?php

use Faker\Factory as Faker;

abstract class ApiTester extends TestCase
{
    protected $fake;

    protected $times = 1;

    public function __construct()
    {
        $this->fake = Faker::create();
    }

    protected function times($count)
    {
        $this->times = $count;

        return $this;
    }

    /**
     * Make a new record in the DB
     * @param   strign    $type
     * @param   array    $fields
     */
    protected function make($type, array $fields = [])
    {
        $type = '\\App\\' . $type;

        while ($this->times--) {
            $stub = array_merge($this->getStub(), $fields);
            $type::create($stub);
        }
    }

    protected function getStub()
    {
        throw new BadMethodCallException('Create your own getStub method to declare your fields.');
    }

    protected function getJson($uri)
    {
        return  json_decode($this->call('GET', $uri)->getContent());
    }

    protected function assertObjectHasAttributes()
    {
        $args = func_get_args();
        $object = array_shift($args);

        foreach ($args as $attribute) {
            $this->assertObjectHasAttribute($attribute, $object);
        }
    }
}
