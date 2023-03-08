<?php declare(strict_types=1);

namespace Feather\Database;

use Feather\Database\Exceptions\ModelException;

abstract class Model 
{
    const REQUIRED = true;
    const OPTIONAL = false;
    private array $data = [];

    public function getValue(
        string $key, 
        mixed $default = null, 
        bool $required = true
    ): mixed {
        if (!\array_key_exists($key, $this->data) && $required) {
            throw new ModelException('Required field ' . $key . 'missing');
        }

        return $this->data[$key];
    }

    public function setData(array $data): Model
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Serialize the data for saving to database
     */
    abstract public function serialize(): array;

    /**
     * Serialize the data for other uses than database saving.
     * Possibility to leave out secret fields such as password etc.
     */
    abstract public function safeSerialize(): array;

    /**
     * Populate the model with data 
     */
    abstract public function populate(): void;
}