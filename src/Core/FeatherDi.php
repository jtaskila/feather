<?php declare(strict_types=1); 

namespace Feather\Core;

use Feather\AppInfo;
use Feather\Core\Di\Unique;
use Feather\Core\Di\Stateful;
use ReflectionException;
use ReflectionNamedType;
use Feather\Core\Di\Exceptions\DiException;

/**
 * The main dependency injection container. 
 */
class FeatherDi implements Stateful
{
    private static ?FeatherDi $instance = null;
    public array $objects = [];
    private array $config = [];
    private bool $allowConfigs = true;

    private function __construct(){}

    /**
     * Get the instance of the container
     * @throws DiException
     */
    public static function getInstance(): FeatherDi
    {
        if (!self::$instance) {
            throw new DiException('DI container is not initialized');
        }

        return self::$instance;
    }

    /**
     * Initialise the DI container
     *
     * @throws DiException
     */
    public static function init(string $rootDir): FeatherDi
    {
        if(self::$instance) {
            throw new DiException('DI container is already initialized');
        }

        self::$instance = new self();

        $config = require(__DIR__.'/../DiConfig.php');
        self::$instance = new self();
        self::$instance->registerConfig($config);

        $appInfo = self::$instance->getUnique(AppInfo::class, [
            'rootDir' => $rootDir,
            'version' => '0.0.1'
        ]);

        // TODO: REMOVE THIS EVIL HACK
        self::$instance->objects[$appInfo::class] = $appInfo;

        return self::$instance;
    }

    /**
     * Dump the content of the object storage as an array
     */
    public function dumpObjectStorage(): array
    {
        return $this->objects;
    }

    /**
     * Register a config object for DI the container
     *
     * @throws DiException
     */
    public function registerConfig(array $config): void
    {
        if (!$this->allowConfigs) {
            throw new DiException('Configurations are not allowed after DI container is used');
        }
        $this->config = \array_replace_recursive($this->config, $config);
    }

    /**
     * Get the current configuration array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Get an instance of a class. If instance does not exists, it will be created.
     *
     * @throws DiException
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
     *
     * @throws DiException
     */
    public function getUnique(string $class, array $params = [])
    {
        return $this->initObject($class, $params, true);
    }

    /**
     * Get array of object instances
     *
     * @throws DiException
     */
    public function getArray(array $classes, ?string $expect = null): array
    {
        $result = [];
        foreach ($classes as $key => $name) {
            $object = $this->get($name);

            if ($expect) {
                if (!$object instanceof $expect) {
                    throw new DiException(
                        'Unexpected object instance '.
                        \get_class($object) .
                        ' expected ' .
                        $expect
                    );
                }
            }

            $result[$key] = $object;
        }

        return $result;
    }

    /**
     * Instantiate a object from given class name.
     *
     * @throws DiException
     */
    private function initObject(string $class, array $params = [], bool $unique = false) 
    {
        /**
         * Set the flag to disallow configuration changes 
         */
        $this->allowConfigs = false;

        if (!\class_exists($class)) {
            throw new DiException('Can not resolve class: '.$class);
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
            } else if ($type instanceof ReflectionNamedType && !$type->isBuiltin() && !\array_key_exists($param->getName(), $params)) {

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

                    if (!$unique || !$instance instanceof Unique) {
                        $this->objects[$type->getName()] = $instance;
                    }
                }
            } else {
                $name = $param->getName();

                if ($params && \array_key_exists($name, $params)) {
                    $dependencies[] = $params[$name];
                } else {
                    if (!$param->isOptional()) {
                        throw new DiException('Missing parameter in object instantiation: '.$class.': "'.$name.'"');
                    }
                }
            }
        }

        /**
         * Return the object with generated dependencies 
         */
        try {
            $class = $reflectionClass->newInstance(...$dependencies);
        } catch (ReflectionException $e) {
            throw new DiException($e->getMessage());
        }

        return $class;
    }
}