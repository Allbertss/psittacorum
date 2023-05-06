<?php

namespace allbertss\psittacorum\test;

use allbertss\psittacorum\container\Container;
use allbertss\psittacorum\container\exception\ContainerException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ContainerTest extends TestCase
{
    /**
     * @throws ContainerExceptionInterface
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     */
    public function test_a_service_can_be_retrieved_from_the_container(): void
    {
        $container = new Container();

        $container->add('dependant-class', DependantClass::class);

        $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
    }

    public function test_a_ContainerException_is_thrown_if_a_service_cannot_be_found(): void
    {
        $container = new Container();

        $this->expectException(ContainerException::class);

        $container->add('non-existent-class');
    }

    /**
     * @throws ContainerException
     */
    public function test_can_check_if_the_container_has_a_service(): void
    {
        $container = new Container();

        $container->add('dependant-class', DependantClass::class);

        $this->assertTrue($container->has('dependant-class'));
        $this->assertFalse($container->has('non-existent-class'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ContainerException
     */
    public function test_services_can_be_recursively_autowired(): void
    {
        $container = new Container();

        $dependantService = $container->get(DependantClass::class);
        $dependencyService = $dependantService->getDependency();

        $this->assertInstanceOf(DependencyClass::class, $dependencyService);
        $this->assertInstanceOf(SubDependencyClass::class, $dependencyService->getSubDependencyClass());
    }
}