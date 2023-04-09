<?php declare(strict_types=1);

namespace Feather\Http;

use Feather\Routing\Data\Uri\Uri;
use Feather\Routing\Data\Uri\UriFactory;
use Feather\Http\Data\ContentType;
use Feather\Http\Content\Parser as ContentParser;

/**
 * Class which holds information about the HTTP request. 
 * This class is completely self contained and can be injected 
 * by referencing the class directly.
 */
class Request 
{
    private Uri $uri;
    private ContentParser $contentParser;

    private string $url;
    private string $method;
    private string $contentType;
    private array $headers;
    private array $body;
    private array $files = [];    

    public function __construct(
        UriFactory $uriFactory,
        ContentParser $contentParser
    ) {   
        /** If called from cli there is no request */
        if (defined('FEATHER_CLI_MODE')) {
            return;
        }

        $this->contentParser = $contentParser;
        $this->url = $_SERVER['REQUEST_URI'] ?? '';
        $this->uri = $uriFactory->create($this->url);
        
        $this->method = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->headers = \getallheaders();

        $this->contentType = '';
        if (isset($_SERVER['CONTENT_TYPE'])) {
            $this->contentType = $_SERVER["CONTENT_TYPE"];
        }

        $this->body = $this->contentParser->parse(
            $this->contentType, 
            $this->getRequestBody()
        );
    }

    private function getRequestBody() 
    {
        return [];
    }

    /**
     * Get raw $_FILES array 
     */
    public function getFiles() : array 
    {
        return $this->files;
    }

    /**
     * Get the unmodified real request URL
     */
    public function getUrl() : string 
    {
        return $this->url;
    }

    /**
     * Get the request method 
     */
    public function getMethod() : string 
    {
        return $this->method;
    }

    /**
     * Get the request content type 
     */
    public function getContentType() : string 
    {
        return $this->contentType;
    }

    /**
     * Get the request headers as an array 
     */
    public function getHeaders() : array 
    {
        return $this->headers;
    }

    public function getBody() : array
    {
        return $this->body;
    }

    /**
     * Returns the Uri object of the current request 
     * 
     * NOTE: params are uninitialized until Router injects them in getResource()
     */
    public function getUri() : Uri 
    {
        return $this->uri;
    }

    /**
     * Set the Uri object for request 
     * 
     * NOTE: It is discouraged to use this anywhere, ever, let the Router handle this 
     */
    public function setUri(Uri $uri) : void 
    {   
        $this->uri = $uri;
    }

    /**
     * Get an URL param from request 
     */
    public function getParam(string $name) : ?string 
    {
        $params = $this->getUri()->getUriParams();

        if (isset($params[$name])) {
            return $params[$name];
        }

        return null;
    }

    /**
     * Get a query parameter from request URL 
     */
    public function getQueryParam(string $name) : ?string 
    {
        $params = $this->getUri()->getQueryParams();

        if (isset($params[$name])) {
            return $params[$name];
        }

        return null;
    }
}