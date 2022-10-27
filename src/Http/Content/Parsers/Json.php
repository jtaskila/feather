<?php 

namespace Feather\Http\Content\Parsers;

use ParserInterface;

class Json implements ParserInterface
{
    public function parse(string $raw) : array 
    {
        return [];
    }
}