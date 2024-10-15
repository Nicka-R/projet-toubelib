<?php
namespace toubeelib\core\domain\entities\user;

use toubeelib\core\domain\entities\Entity;

class User extends Entity{
    protected string $id;
    protected string $email;
    protected string $password;
    protected string $role;

    public function __construct(string $email, string $password, string $role){
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRole(){
        return $this->role;
    }

}