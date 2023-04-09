<?php declare(strict_types=1);

namespace Feather\Routing\Data\Uri;

use Feather\Core\FeatherDi;

/**
 * Factory for creating Uri objects from URL strings or already parsed arrays 
 */
class UriFactory 
{
    private FeatherDi $featherDi;
    private UriBuilder $builder;

    public function __construct(
        FeatherDi $featherDi,
        UriBuilder $builder
    )
    {
        $this->featherDi = $featherDi;
        $this->builder = $builder;
    }

    /**
     * Create an Uri object instance from URL string 
     */
    public function create(string $url): Uri 
    {
        $uri = $this->builder->getExplodedUri($url);
        $query = $this->builder->getExplodedQueryParams($url);

        /** @var Uri $uri */
        $uri = $this->featherDi->getUnique(Uri::class, 
            [
                'uri' => $uri, 
                'query' => $query,
                'params' => []
            ]
        );

        return $uri;
    }

    /**
     * Create an Uri object instance from existing params 
     */
    public function createInstance(array $params) 
    {
        return $this->featherDi->getUnique(Uri::class, $params);
    }
}