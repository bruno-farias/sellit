<?php

namespace Tests\Feature;


use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Helpers\Creator;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;


    /** @var Creator $creator */
    private $creator;
    /** @var User $user */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->creator = new Creator();
        $this->user = $this->creator->createUser();
    }

    public function testUserCanRegister()
    {
        $userData = [
            'name' => $this->randoms->name(),
            'email' => $this->randoms->email(),
            'password' => $this->randoms->password()
        ];

        $this->json('POST', '/api/auth/register', $userData)
            ->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in'
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email']
        ]);
    }

    public function testUserCantRegisterMissingParameters()
    {
        $userData = [
            'name' => $this->randoms->name(),
            'email' => $this->randoms->email(),
            'password' => $this->randoms->password()
        ];
        $userData = array_slice($userData, rand(0, count($userData)), 1);

        $this->json('POST', '/api/auth/register', $userData)
            ->assertStatus(422);
    }

    public function testUserCanLogin()
    {
        $password = $this->randoms->password();
        $user = $this->creator->createUser([
            'password' => bcrypt($password)
        ]);

        $this->json('POST', '/api/auth/login', ['email' => $user->email, 'password' => $password])
            ->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in'
            ]);
    }

    public function testUserCanGetOwnDetails()
    {
        $this->actingAs($this->user)->json('POST', '/api/auth/me')
            ->assertOk()
            ->assertJson([
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'email_verified_at' => $this->user->email_verified_at,
                'created_at' => $this->user->created_at,
                'updated_at' => $this->user->updated_at,
            ]);
    }

    public function testUserCannotLoginWithWrongCredentials()
    {
        $password = $this->randoms->password();

        $this->json('POST', '/api/auth/login', ['email' => $this->user->email, 'password' => $password])
            ->assertStatus(401);
    }

    public function testUserLogout()
    {
        $this->actingAs($this->user)->json('POST', '/api/auth/logout')
            ->assertOk()
            ->assertJson([
                'message' => 'Successfully logged out'
            ]);
    }
}