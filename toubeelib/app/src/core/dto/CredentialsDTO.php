<?php
namespace toubeelib\core\dto;

class CredentialsDTO extends DTO {
    public string $email;
    public string $password;

    public function __construct(string $email, string $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }
}