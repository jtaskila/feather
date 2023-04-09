<?php declare(strict_types=1);

namespace Feather\Database\Schema\Column;


class BigInteger extends Integer 
{
    public function getType(): string 
    {
        return 'BIGINT';
    }
}