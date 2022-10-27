<?php declare(strict_types=1); 

namespace Feather\Core;

use ReflectionNamedType;

/**
 * The main dependency injection container. 
 */
class FeatherDi
{
    const PREFERENCE = 'preference';
    const CONFIG = 'config';

    private static ?FeatherDi $instance = null;
    private array $objects = [];
    private array $config = [];
    private bool $allowConfigs = true;

    private function __construct(){}

    /**
     * Get the instance of the container 
     */
    public static function getInstance() : FeatherDi
    {
        if (!self::$instance) {
            $config = require(__DIR__.'/../DiConfig.php');
            self::$instance = new self();       
            self::$instance->registerConfig($config);
        }
        return self::$instance;
    }

    /**
     * Register a config object for DI the container 
     */
    public function registerConfig(array $config) : void 
    {
        if (!$this->allowConfigs) {
            throw new \Exception('Configurations are not allowed after DI container is used');
        }
        $this->config = \array_replace_recursive($this->config, $config);
    }

    /**
     * Returns the current configuration array 
     */
    public function getConfig() : array 
    {
        return $this->config;
    }

    /**
     * Get an instance of a class. If instance does not exists, it will be created.
     */
    public function get(string $class) 
    {   
        if (\array_key_exists($class, $this->objects)) {
            return $this->objects[$class];
        }
        
        return $this->initObject($class);
    }

    /**
     * Get a unique instance of a class. 
     */
    public function getUnique(string $class, array $params = []) 
    {
        return $this->initObject($class, $params, true);
    }

    /**
     * Instantiate a object from given class name.
     */
    private function initObject(string $class, array $params = [], bool $unique = false) 
    {
        /**
         * Set the flag to disallow configuration changes 
         */
        $this->allowConfigs = false;

        if (!\class_exists($class)) {
            throw new \Exception('Can not resolve class: '.$class);
        }

        /**
         * Include params registed by configurations 
         */
        if (isset($this->config[$class])) {
            $params = \array_replace_recursive(
                $this->config[$class],
                $params 
            );
        }

        $reflectionClass = new \ReflectionClass($class);

        $constructor = $reflectionClass->getConstructor();
        $constructorParams = [];

        if ($constructor) {
            $constructorParams = $constructor->getParameters();
        }

        $dependencies = [];

        foreach ($constructorParams as $param) {
            $type = $param->getType();

            if ($type->getName() == FeatherDi::class) {

                /**
                 * When the DI container itself is needed as a dependency,
                 * return the singleton instance of it.
                 */
                $dependencies[] = self::getInstance();
            } else if ($type && $type instanceof ReflectionNamedType && !$type->isBuiltin() && !\array_key_exists($param->getName(), $params)) {

                /**
                 * Instantiating an object. First checking the cache array if the
                 * object already exists and request is not for an unique object.
                 */
                if (!$unique && \array_key_exists($type->getName(), $this->objects)) {
                    $instance = $this->objects[$type->getName()];
                    $dependencies[] = $instance;
                } else {
                    $instance = $this->initObject($type->getName());                    
                    $dependencies[] = $instance;   

                    if (!$unique) {
                        $this->objects[$type->getName()] = $instance;
                    }
                }
            } else {
                $name = $param->getName();

                if ($params && \array_key_exists($name, $params)) {
                    $dependencies[] = $params[$name];
                } else {
                    if (!$param->isOptional()) {
                        throw new \Exception('Missing parameter in object instantiation: '.$class.', '.$name);
                    }
                }
            }
        }

        /**
         * Return the object with generated dependencies 
         */
        return $reflectionClass->newInstance(...$dependencies);     
    }
}