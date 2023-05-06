<?php

namespace App\controller;

use allbertss\psittacorum\http\Response;
use App\Widget;

class HomeController
{
    public function __construct(
        private Widget $widget
    )
    {
    }

    public function index(): Response
    {
        return new Response("Hello {$this->widget->name}");
    }

    public function show(int $id): Response
    {
        return new Response("Id: $id");
    }
}