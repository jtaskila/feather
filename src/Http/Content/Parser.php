<?php declare(strict_types=1);

namespace Feather\Http\Content;

use Feather\Core\FeatherDi;

/**
 * Class for handling request body parsing,
 * matches request content-type to a parser 
 * declared by DI configuration.
 */
class Parser 
{
    /**
     * Array of classes which implement \Feather\Http\Content\ParserInterface
     */
    private array $parsers;

    public function __construct(
        array $parsers = []
    ) {
        $this->parsers = $this->initParsers($parsers);
    }

    public function parse(string $contentType, mixed $body ) : array  
    {
        foreach ($this->parsers as $type => $parser) {
            if ($type === $contentType) {
                return $parser->parse($body);
            }
        }

        return [];
    }

    private function initParsers(array $parsers) 
    {
        return FeatherDi::getInstance()
            ->getArray($parsers, ParserInterface::class);
    }
}