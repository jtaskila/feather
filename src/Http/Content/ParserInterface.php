<?php 

namespace Feather\Http\Content;

/**
 * An interface which all request body parsers have to implement
 */
interface ParserInterface
{
    public function parse(string $body) : array;
}