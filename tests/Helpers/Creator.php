<?php


namespace Tests\Helpers;


use App\User;

class Creator
{
    public function createUser(array $params = []): User
    {
        return factory(User::class)->create($params);
    }
}