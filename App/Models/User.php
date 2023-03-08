<?php

namespace App\Models;

use Feather\Database\Model;

class User extends Model
{
    const TABLE = 'user';
    const PRIMARY_KEY = 'id';
    const JOINED_MODELS = [
        'address' => UserAddress::class
    ];

    private ?int $id = null;
    private string $name;
    private string $password;
    private string $email;
    private ?UserAddress $address = null;

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?UserAddress
    {
        return $this->address;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }

    public function safeSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => null
        ];
    }

    public function populate(): void
    {
        $this->id       = $this->getValue('id');
        $this->name     = $this->getValue('name', '', self::OPTIONAL);
        $this->email    = $this->getValue('email');
        $this->password = $this->getValue('password');
    }
}