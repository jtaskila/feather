<?php declare(strict_types=1);

namespace Feather\Http;

use Feather\Http\Data\Charset;
use Feather\Http\Data\ContentType;

/**
 * Class which holds the HTTP response
 */
class Response 
{
    private int $status;
    private string $contentType;
    private string $charset;
    private ?string $body;
    private array $headers;

    public function __construct(
        int $status,
        ?string $body
    ) {
        $this->status = $status;
        $this->body = $body;
        $this->contentType = ContentType::JSON;
        $this->charset = Charset::UTF8;
        $this->headers = [];
    }

    public function getStatus(): int 
    {
        return $this->status;
    }

    public function getBody(): string 
    {
        return $this->body;
    }

    public function addHeader(string $key, string $value): Response 
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function setContentType(string $contentType): Response 
    {
        $this->contentType = $contentType;
        return $this;
    }

    public function setBody(string $body) : Response 
    {
        $this->body = $body;
        return $this;
    }

    public function serve(): void 
    {
        \http_response_code($this->status);
        
        \header('Content-type: '.$this->contentType.'; charset='.$this->charset);
        
        foreach($this->headers as $key => $value) {
            \header($key.': '.$value);
        }

        if ($this->body !== null) {
            echo $this->body;
        }
    }
}