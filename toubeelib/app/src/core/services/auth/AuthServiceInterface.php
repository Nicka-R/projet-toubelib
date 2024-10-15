<?php

namespace toubeelib\core\services\auth;

use toubeelib\core\dto\AuthDTO;
use toubeelib\core\dto\InputAuthDTO;
use toubeelib\core\repositoryInterfaces\UserRepositoryInterface;
use toubeelib\core\exceptions\AuthenticationException;

interface AuthServiceInterface
{
    public function authenticate(InputAuthDTO $authDTO): AuthDTO;
}