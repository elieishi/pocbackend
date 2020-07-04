<?php


namespace App\Http\repositories;


use App\User;

/**
 * Class UserRepository
 * @package App\Http\repositories
 */
class UserRepository
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $validatedData
     * @return User
     */
    public function store(array $validatedData)
    {
        $validatedData['password'] = bcrypt($validatedData['password']);
        return $this->user->create($validatedData);
    }


}
