<?php

namespace App\Modules\Api\Response;

class UserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $token,
        public ?string $email_verified_at,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token,
            'email_verified_at' => $this->email_verified_at,
        ];
    }
}