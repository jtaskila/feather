<?php declare(strict_types=1);

namespace Feather\Database;

class ModelRepository 
{
    private DataRepository $dataRepository;

    public function __construct(
        DataRepository $dataRepository
    ) {
        $this->dataRepository = $dataRepository;
    }

    
}