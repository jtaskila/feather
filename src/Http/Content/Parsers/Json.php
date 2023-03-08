<?php 

namespace Feather\Http\Content\Parsers;

use Feather\Http\Content\ParserInterface;

class Json implements ParserInterface
{
    public function parse(string $body) : array 
    {
        return \json_decode($body, true);
    }
}