<?php
namespace toubeelib\core\services\auth;

use toubeelib\core\dto\InputAuthDTO;
use toubeelib\core\dto\AuthDTO;
use toubeelib\core\services\auth\AuthenticationException;

class AuthProvider {
    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function signin(InputAuthDTO $authDTO): AuthDTO {
        try {
            $user = $this->authService->authenticate($authDTO);
            // print_r($user);

            //génération des tokens d'accès et de rafraîchissement 
            $accessToken = bin2hex(random_bytes(16));
            $refreshToken = bin2hex(random_bytes(16));

            return new AuthDTO(
                $user->getId(),
                $user->getEmail(),
                $user->getHashedPassword(),
                $user->getRole(),
                $accessToken,
                $refreshToken
            );
        } catch (AuthenticationException $e) {
            throw new AuthenticationException('Invalid credentials');
        }
    }
}