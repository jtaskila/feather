<?php 

interface ParserInterface
{
    public function parse(string $raw) : array;
}