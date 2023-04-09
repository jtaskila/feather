<?php declare(strict_types=1);

namespace Feather\Database\Schema;

use Feather\Database\Schema\Column\AutoIncrement;
use Feather\Database\Schema\Column\BigInteger;
use Feather\Database\Schema\Column\Integer;
use Feather\Database\Schema\Column\Text;
use Feather\Database\Schema\Column\TinyInteger;
use Feather\Database\Schema\Column\Varchar;

class Table implements TableInterface
{
    public function getSchema(): array
    {
        return [
            'id' => (new Integer()),
            'another_test' => (new Varchar()),
            'test' => (new Varchar()),
            'field' => (new Integer()),
        ];
    }

    public function getName(): string
    {
        return 'test_table_2';
    }

    public function getIndexes(): array
    {
        return [];
    }

    public function getForeignKeys(): array
    {
        return [];
    }
}