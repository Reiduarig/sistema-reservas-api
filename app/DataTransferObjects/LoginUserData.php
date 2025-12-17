<?php

namespace App\DataTransferObjects;

readonly class LoginUserData
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
