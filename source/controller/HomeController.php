<?php

namespace App\controller;

use allbertss\psittacorum\http\Response;

class HomeController
{
    public function index(): Response
    {
        return new Response('xdddd');
    }

    public function show(int $id): Response
    {
        return new Response("Id: $id");
    }
}