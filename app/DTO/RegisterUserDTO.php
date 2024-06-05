<?php

namespace App\DTO;

class RegisterUserDTO
{
    public function __construct(
        public string $userName,
        public string $email,
        public string $password
    ) {
    }
}
