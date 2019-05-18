<?php


namespace Tests\Helpers;


use Faker\Factory;

class Randoms
{
    /** @var \Faker\Generator $generator */
    private $generator;

    public function __construct()
    {
        $this->generator = Factory::create();
    }

    public function name()
    {
        return $this->generator->name;
    }

    public function email()
    {
        return $this->generator->email;
    }

    public function password(): string
    {
        return $this->generator->password;
    }

    public function description()
    {
        return $this->generator->text;
    }

    public function price()
    {
        return $this->generator->randomFloat(2, 0, 9999);
    }

}