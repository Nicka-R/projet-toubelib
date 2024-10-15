<?php
namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubeelib\core\services\auth\AuthProvider;
use toubeelib\core\dto\InputAuthDTO;
use toubeelib\core\services\auth\AuthenticationException;
use Slim\Psr7\Response as SlimResponse;

class AuthAction extends AbstractAction {
    private AuthProvider $authProvider;

    public function __construct(AuthProvider $authProvider) {
        $this->authProvider = $authProvider;
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $data = $request->getParsedBody();

        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->respondWithError($response, 'Email and password are required', 400);
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->respondWithError($response, 'Invalid email format', 400);
        }

        try {
            $authDTO = new InputAuthDTO($data['email'], $data['password']);
            $authToken = $this->authProvider->signin($authDTO);

            $responseData = [
                'accessToken' => $authToken->getAccessToken(),
                'refreshToken' => $authToken->getRefreshToken(),
            ];

            $response->getBody()->write(json_encode($responseData));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (AuthenticationException $e) {
            return $this->respondWithError($response, 'Invalid credentials', 401);
        }
    }

    private function respondWithError(Response $response, string $message, int $status): Response {
        $responseData = ['error' => $message];
        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}