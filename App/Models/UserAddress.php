<?php 

namespace App\Models;

use Feather\Database\Model;

class UserAddress extends Model
{
    private ?int $id = null;
    private string $street;
    private string $postalCode;
    private string $city;

    public function getId(): string 
    {
        return $this->id;
    }

    public function getStreet(): string 
    {
        return $this->street;
    }

    public function setStreet(string $street): UserAddress
    {
        $this->street = $street;
        
        return $this;
    }

    public function setPostalCode(string $postalCode): UserAddress
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function setCity(string $city): UserAddress
    {
        $this->city = $city;
        
        return $this;
    }

    public function getPostalCode(): string 
    {
        return $this->postalCode;
    }

    public function getCity(): string 
    {
        return $this->city;
    }

    public function populate(): void 
    {
        $this->id = $this->getValue('id');
        $this->street = $this->getValue('street');
        $this->postalCode = $this->getValue('postal_code');
        $this->city = $this->getValue('city');
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'street' => $this->street,
            'postal_code' => $this->postalCode,
            'city' => $this->city
        ];
    }
    public function safeSerialize(): array
    {
        return $this->serialize();
    }
}