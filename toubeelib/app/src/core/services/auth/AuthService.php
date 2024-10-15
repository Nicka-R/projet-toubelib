<?php
namespace toubeelib\core\services\auth;

use toubeelib\core\dto\AuthDTO;
use toubeelib\core\dto\InputAuthDTO;
use toubeelib\core\repositoryInterfaces\UserRepositoryInterface;
use toubeelib\core\services\auth\AuthenticationException;

class AuthService implements AuthServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(InputAuthDTO $authDTO): AuthDTO
    {
        $user = $this->userRepository->findByEmail($authDTO->getEmail());

        if (!$user || !password_verify($authDTO->getPassword(), $user->getHashedPassword())) {
            throw new AuthenticationException('Invalid credentials');
        }

        return new AuthDTO($user->getId(), $user->getEmail(), $user->getHashedPassword(), $user->getRole());
    }
}