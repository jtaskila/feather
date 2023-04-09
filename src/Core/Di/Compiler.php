<?php declare(strict_types=1);

namespace Feather\Core\Di;

use Feather\Core\Di\Exceptions\DiException;

class Compiler 
{
    /**
     * Searches and compiles all DiConfigs to a single array 
     */
    public function getConfig(bool $developmentMode): array
    {
        if ($developmentMode) {
            return $this->generateDiConfig();
        }

        $outputFile = \sprintf(
            '../../../diConfig.php'
        );

        if (!\file_exists($outputFile)) {
            throw new DiException('DiConfig not found');
        }
    }

    private function generateDiConfig(): array 
    {
        $classes = \get_declared_classes();
        $config = [];

        foreach ($classes as $className) 
        {
            echo $className.PHP_EOL;
            if (\in_array(DiConfigInterface::class, \class_implements($className))) {
                $configClass = new $className();
                $config = \array_merge($config, $configClass->getConfig());
            }
        }
        
        return $config;
    }
}