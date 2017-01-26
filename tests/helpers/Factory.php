<?php

trait Factory
{
    /**
     * @var intreger
     */
    protected $times = 1;

    /**
     * Number of times to make entities
     * @param   int    $count
     * @return  $this
     */
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
}
