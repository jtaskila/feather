<?php declare(strict_types=1);

namespace Feather\Http\Content;

use Feather\Http\Data\ContentType;

class Parser 
{
    /**
     * Array of classes which implement \Feather\Http\Content\ParserInterface
     */
    private array $parsers;

    public function __construct(
        array $parsers = []
    ) {
        $this->parsers = $parsers;
    }

    public function parse(string $contentType, mixed $body ) : array  
    {
        switch ($contentType) {
            case ContentType::JSON:
                break;
            case ContentType::FORM:
                break;
            case ContentType::MULTIPART:
                break;
        }

        return [];
    }
}