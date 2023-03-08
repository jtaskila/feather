<?php declare(strict_types=1);

namespace Feather\Core\Collection;

/**
* This is a base collection class with basic methods for
* handling collections of any data type. Basically a wrapper for array.
*
* Collections also support strict typing which can be enabled by extending the Collection class
* and calling enableStrictTypes in constructor.
*/
class Collection
{
    protected array $data = array();
    protected bool $strict = false;
    protected ?string $type = null;

    /**
    * Enable strict typing for collection
    */
    public function enableStrictTypes(string $type)
    {
        if ($this->strict) {
            throw new \Exception('Strict typing for collection is allowed to be set only once!');
        }
        $this->type = $type;
        $this->strict = true;
    }

    /**
    * Method for internal strict type checks
    */
    private function checkStrictTypes($element)
    {
        if ($this->strict && gettype($element) !== $this->type && !($element instanceof $this->type)){
            $typeString = (gettype($element) == 'object') ? get_class($element) : gettype($element);
            throw new \InvalidArgumentException('Collection element type mismatch, expecting: '.$this->type.', got '.$typeString.' instead.');
        }
    }

    /**
     * Get the collection type, returns null if type is not set
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
    * Return all items as assosiative array
    */
    public function items(): array
    {
        return $this->data;
    }

    /**
    * Get the first item of the collection
    */
    public function first(): mixed{
        if (array_key_exists(0, $this->data)) {
            return $this->data[0];
        }
    }

    /**
    * Get the last item of the collection
    */
    public function last(): mixed
    {
        if (array_key_exists(-1, $this->data)) {
            return $this->data[-1];
        }
    }

    /**
    * Return only the valus as normal array
    */
    public function values(): array
    {
        return array_values($this->data);
    }

    /**
    * Get the number of elements in collection
    */
    public function count(): int
    {
        return count($this->data);
    }

    /**
    * Add element to collection and specify a key for it
    */
    public function add($key, $element): void
    {
        $this->checkStrictTypes($element);

        if (array_key_exists($key, $this->data)) {
            throw new \InvalidArgumentException("Collection key: ".$key." already exists!");
        }
        $this->data[$key] = $element;
    }

    /**
    * Add multiple elements from a key, value array.
    * Overwriting keys is not permitted.
    */
    public function addMany(array $elements): void
    {
        foreach ($elements as $key => $element) {
            $this->add($key, $element);
        }
    }

    /**
    * Append an element to collection. The key is assigned automatically
    */
    public function append($element): void
    {
        $this->checkStrictTypes($element);
        $this->data[] = $element;
    }

    /**
    * Append many elements to collection.
    */
    public function appendMany(array $elements): void
    {
        foreach (array_values($elements) as $element) {
            $this->append($element);
        }
    }

    /**
    * Replace an element in the collection by key
    */
    public function replace($key, $element, $safe = true): void
    {
        if (!array_key_exists($key, $this->data) && $safe) {
            throw new \OutOfRangeException("Collection key: ".$key." does not exist!");
        }
        $this->checkStrictTypes($element);
        $this->data[$key] = $element;
    }

    /**
    * Remove element from collection by key
    */
    public function remove($key): void
    {
        if (array_key_exists($key, $this->data)) {
            array_splice($this->data, $key, 1);
        } else {
            throw new \OutOfRangeException("Collection key: ".$key." does not exist!");
        }
    }

    /**
    * Get an element from collection by key
    */
    public function get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        } else {
            throw new \OutOfRangeException("Collection key: ".$key." does not exist!");
        }
    }
}
