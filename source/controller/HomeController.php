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

    public function show(int $id): Response
    {
        return new Response("Id: $id");
    }
}