<?php

namespace allbertss\psittacorum\container;

use allbertss\psittacorum\container\exception\ContainerException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    private array $services = [];

    /**
     * @param string $id
     * @param string|object|null $concrete
     * @return void
     * @throws ContainerException
     */
    public function add(string $id, string|object $concrete = null): void
    {
        if ($concrete === null) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id could not be found.");
            }

            $concrete = $id;
        }

        $this->services[$id] = $concrete;
    }

    public function get(string $id)
    {
        if (!$this->has($id)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id could not be resolved.");
            }

            $this->add($id);
        }

        return $this->resolve($this->services[$id]);
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }

    /**
     * @throws \ReflectionException
     */
    private function resolve($class): object
    {
        // 1. Instantiate a Reflection class
        $reflectionClass = new \ReflectionClass($class);

        // 2. Use Reflection to try to obtain a class constructor
        $constructor = $reflectionClass->getConstructor();

        // 3. If there is no constructor, simply instantiate
        if ($constructor === null) {
            return $reflectionClass->newInstance();
        }

        // 4. Get the constructor parameters
        $constructorParams = $constructor->getParameters();

        // 5. Obtain dependencies
        $classDependencies = $this->resolveClassDependencies($constructorParams);

        // 6. Instantiate with dependencies and return service
        return $reflectionClass->newInstanceArgs($classDependencies);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function resolveClassDependencies(array $reflectionParameters): array
    {
        // 1. Initialize empty dependencies array
        $classDependencies = [];

        // 2. Try to locate and instantiate each parameter
        /** @var \ReflectionParameter $reflectionParameter */
        foreach ($reflectionParameters as $reflectionParameter) {
            // Get the reflection's parameter's ReflectionNamedType as $serviceType
            $serviceType = $reflectionParameter->getType();

            if (class_exists($name = $serviceType->getName())) {
                $classDependencies[] = $this->get($name);;
            }
        }

        return $classDependencies;
    }
}