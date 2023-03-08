<?php declare(strict_types=1);

namespace Feather\Templates;

use Feather\Core\Di\Unique;

class Template implements Unique
{
    public function toHtml(): string
    {
        return '<h1>This is a template</h1>';
    }
}