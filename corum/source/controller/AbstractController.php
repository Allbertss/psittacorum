<?php

namespace allbertss\psittacorum\controller;

use allbertss\psittacorum\http\Request;
use allbertss\psittacorum\http\Response;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;
    protected Request $request;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function render(string $template, array $parameters = [], Response $response = null): Response
    {
        $content = $this->container->get('twig')->render(
            $template,
            $parameters
        );

        $response ??= new Response();

        $response->setContent($content);

        return $response;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}