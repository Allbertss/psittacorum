<?php

namespace App\controller;

use allbertss\psittacorum\controller\AbstractController;
use allbertss\psittacorum\http\Response;
use App\Widget;

class HomeController extends AbstractController
{
    public function __construct(
        private Widget $widget
    )
    {
    }

    public function index(): Response
    {
        return $this->render(
            'home.html.twig',
            [
                'name' => 'Abc'
            ]
        );
    }

    public function show(string $name): Response
    {
        return $this->render(
            'home.html.twig',
            [
                'name' => $name
            ]
        );
    }

    public function create(): Response
    {
        return $this->render('form.html.twig');
    }
}