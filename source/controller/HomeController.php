<?php

namespace App\controller;

use allbertss\psittacorum\controller\AbstractController;
use allbertss\psittacorum\http\Response;
use App\entity\Home;
use App\mapper\HomeMapper;
use App\repository\HomeRepository;

class HomeController extends AbstractController
{
    public function __construct(
        private HomeMapper $homeMapper,
        private HomeRepository $homeRepository
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
        $home = $this->homeRepository->findById($id);

        return $this->render(
            'home.html.twig',
            [
                'home' => $home
            ]
        );
    }

    public function create(): Response
    {
        return $this->render('form.html.twig');
    }

    public function store(): void
    {
        $title = $this->request->postParameters['title'];
        $body = $this->request->postParameters['body'];

        $home = Home::create($title, $body);

        $this->homeMapper->save($home);

        dd($home);
    }
}