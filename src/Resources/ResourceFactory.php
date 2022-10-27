<?php declare(strict_types=1);

namespace Feather\Resources;

use Feather\Core\FeatherDi;
use Feather\Resources\Resource;

class ResourceFactory 
{
    private FeatherDi $featherDi;

    public function __construct(
        FeatherDi $featherDi
    )
    {
        $this->featherDi = $featherDi;        
    }

    public function create(string $class, array $params = []) : Resource
    {
        return $this->featherDi->getUnique($class, $params);
    }
}