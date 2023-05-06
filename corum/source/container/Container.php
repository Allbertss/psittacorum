<?php

namespace allbertss\psittacorum\container;

use allbertss\psittacorum\container\exception\ContainerException;
use allbertss\psittacorum\test\DependantClass;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];

    /**
     * @param string $id
     * @param string|object|null $concrete
     * @return void
     * @throws ContainerException
     */
    public function add(string $id, string|object $concrete = null)
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
        return new $this->services[$id];
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }
}