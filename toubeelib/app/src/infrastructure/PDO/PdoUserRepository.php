<?php
namespace toubeelib\infrastructure\PDO;

use toubeelib\core\repositoryInterfaces\UserRepositoryInterface;
use toubeelib\core\dto\AuthDTO;
use PDO;

class PdoUserRepository implements UserRepositoryInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): ?AuthDTO {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new AuthDTO($row['id'], $row['email'], $row['password'], $row['role']);
        }
        return null;
    }
}