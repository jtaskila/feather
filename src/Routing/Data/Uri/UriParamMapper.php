<?php declare(strict_types=1);

namespace Feather\Routing\Data\Uri;

use Exception;

/**
 * Utility class to map uri params from real uri based the defined and matched uri
 */
class UriParamMapper
{
    const PARAM_START = '<';
    const PARAM_END = '>';

    private UriFactory $uriFactory;

    public function __construct(
        UriFactory $uriFactory
    ) {
        $this->uriFactory = $uriFactory;
    }

    /**
     * @throws Exception
     */
    public function mapParams(Uri $uri, Uri $resourceUri): Uri
    {
        $uriArray = $uri->getUri();
        $params = [];
        $count = 0;

        if (\count($uri->getUri()) !== \count($resourceUri->getUri())) {
            throw new Exception('Uri length mismatch in param mapping');
        }

        foreach ($resourceUri->getUri() as $item) {
            if ($this->isParam($item)) {
                $params[$this->getParamName($item)] = $uriArray[$count];
            }
            $count++;
        }

        return $this->uriFactory->createInstance( 
            [
                'uri' => $uri->getUri(),
                'query' => $uri->getQueryParams(),
                'params' => $params
            ]
        );
    }

    /**
     * Check if two Uri objects are matching exluding params 
     */
    public function matchUri(Uri $uri, Uri $resourceUri) : bool 
    {
        $uriArray = $uri->getUri();
        $resourceUriArray = $resourceUri->getUri();

        if (count($uriArray) == count($resourceUriArray)) {
            for ($i = 0; $i < count($resourceUriArray); $i++) {
                if (
                    !$this->isParam($resourceUriArray[$i]) and
                    $uriArray[$i] !== $resourceUriArray[$i]
                ) {
                    return false;
                }
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     * Check if a string is a valid param 
     */
    private function isParam(string $param) : bool 
    {
        if (
            substr($param, 0, 1) == $this::PARAM_START &&
            substr($param, -1, 1) == $this::PARAM_END
        ) {
            return true;
        }
        return false;
    }

    /**
     * Get the name of the param from the param string
     */
    private function getParamName(string $param) : string 
    {
        return \substr($param, 1, -1);
    }
}