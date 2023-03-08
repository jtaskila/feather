<?php declare(strict_types=1);

namespace Feather\Core\Collection;

use Feather\Core\FeatherDi;

class CollectionFactory
{
    private FeatherDi $featherDi;

    public function __construct(
        FeatherDi $featherDi
    ) {
        $this->featherDi = $featherDi;
    }

    public function create(string $type = null) : Collection 
    {
        /** @var Collection */
        $collection = $this->featherDi->getUnique(Collection::class, []);

        if ($type) {
            $collection->enableStrictTypes($type);
        }

        return $collection;
    }
}