<?php declare(strict_types=1);

namespace Feather\Routing\Data\Uri;

/**
 * Data class containing information about unique request identifiers (uri's)
 */
class Uri 
{
    private array $uri;
    private array $query;
    private ?array $params;

    public function __construct(
        array $uri,
        array $query,
        ?array $params = null 
    ) {
        $this->uri = $uri;
        $this->query = $query;
        $this->params = $params;
    }

    public function getUri() : array 
    {
        return $this->uri;
    }

    public function getQueryParams() : array 
    {
        return $this->query;
    }

    public function getUriParams() : array 
    {
        if ($this->params === null) {
            throw new \Exception('Uri params are not initialized');
        }
        return $this->params;
    }

    public function setUriParams(array $params) : void 
    {
        $this->params = $params;
    }
}