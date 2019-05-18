<?php

namespace Tests;

use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\Helpers\Randoms;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /** @var User $user */
    protected $user;
    /** @var Randoms $randoms */
    protected $randoms;

    public function setUp(): void
    {
        parent::setUp();
        $this->randoms = new Randoms();
    }

    public function actingAs(Authenticatable $user, $driver = null): TestCase
    {
        $this->user = $user;
        return $this;
    }
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null): TestResponse
    {
        if ($this->user) {
            $token = JWTAuth::fromUser($this->user);
            JWTAuth::setToken($token);
            $server['HTTP_AUTHORIZATION'] = 'Bearer ' . $token;
        }
        $server['HTTP_ACCEPT'] = 'application/json';
        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }
}
