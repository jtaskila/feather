<?php declare(strict_types=1);

namespace Feather\Templates;

use Feather\Core\Di\Unique;

class Template
{
    public function render(): string
    {
        return '<h1>This is a template</h1>';
    }
}