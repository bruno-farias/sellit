<?php


namespace App\Services;


use App\User;
use Carbon\Carbon;

class UserService
{
    /** @var User $model */
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $payload): User
    {
        $payload = array_merge($payload, [
            'email_verified_at' => Carbon::now()
        ]);
        $user = $this->model->create($payload);

        $user->save();

        return $user;
    }

    public function findByEmail($email): ?User
    {
        return $this->model->where('email', $email)->first();
    }
}