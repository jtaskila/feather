<?php declare(strict_types=1);

namespace Feather\Routing\Data\Uri;

use Feather\AppInfo;

/**
 * Utility class for creating arrays from URL strings 
 */
class UriBuilder
{
    private AppInfo $appInfo;

    public function __construct(
        AppInfo $appInfo
    ) {
        $this->appInfo = $appInfo;
    }

    /**
     * Returns the URI part of the URL as a string 
     */
    public function getUriFromUrl(string $url): string
    {
        return \str_replace(
            $this->appInfo->getBaseUrl(),
            '',
            $url
        );
    }

    /**
     * Returns the URI part of the URL as and array without query parameters 
     */
    public function getExplodedUri(string $url) : array 
    {
        $url = $this->getUriFromUrl($url);

        $uriArray = explode('?', $url);
        $explodedUri = explode('/', $uriArray[0]);

       array_splice($explodedUri, 0, 1);

       return $explodedUri;
    }

    /**
     * Returns the query parameters from the URL as array 
     */
    public function getExplodedQueryParams(string $url) : array 
    {
        $urlArray = explode('?', $url);

        $queryParams = [];

        if (isset($urlArray[1])) {
            $explodedQuery = explode('&', $urlArray[1]);

            foreach ($explodedQuery as $param) {
                $explodedParam = explode('=', $param);

                if (!isset($explodedParam[0]) || !isset($explodedParam[1])) {
                    continue;
                }

                if (!isset($queryParams[$explodedParam[0]])) {
                    $queryParams[$explodedParam[0]] = $explodedParam[1];
                }
            }            
        }

        return $queryParams;
    }
}