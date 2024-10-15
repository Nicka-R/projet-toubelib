<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\dto\AuthDTO;

interface UserRepositoryInterface {
    public function findByEmail(string $email): ?AuthDTO;
}