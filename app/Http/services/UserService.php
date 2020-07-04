<?php


namespace App\Http\services;

use App\Http\repositories\UserRepository;

/**
 * Class UserService
 * @package App\Http\services
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function createUser(array $validated)
    {
        return $this->userRepository->store($validated);
    }

}
