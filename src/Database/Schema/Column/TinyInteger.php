<?php declare(strict_types=1);

namespace Feather\Database\Schema\Column;


class TinyInteger extends Integer 
{
    public function getType(): string 
    {
        return 'TINYINT';
    }
}