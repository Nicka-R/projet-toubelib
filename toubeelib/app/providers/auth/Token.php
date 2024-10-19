<?php
namespace app\providers\auth;
class Token {
    public string $value;

    public function __construct(string $value) {
        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }
}