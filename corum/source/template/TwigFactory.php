<?php

namespace allbertss\psittacorum\template;

use allbertss\psittacorum\session\SessionInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigFactory
{
    public function __construct(
        private SessionInterface $session,
        private string $templatePath
    )
    {
    }

    public function create(): Environment
    {
        $loader = new FilesystemLoader($this->templatePath);

        // TODO: set these from env.
        $twig = new Environment($loader, [
            'debug' => true,
            'cache' => false
        ]);

        $twig->addExtension(new DebugExtension());
        $twig->addFunction(new TwigFunction('session', [$this, 'getSession']));

        return $twig;
    }

    public function getSession(): SessionInterface
    {
        return $this->session;
    }
}