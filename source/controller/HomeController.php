<?php

namespace App\controller;

use allbertss\psittacorum\controller\AbstractController;
use allbertss\psittacorum\http\RedirectResponse;
use allbertss\psittacorum\http\Response;
use allbertss\psittacorum\session\SessionInterface;
use App\entity\Home;
use App\mapper\HomeMapper;
use App\repository\HomeRepository;

class HomeController extends AbstractController
{
    public function __construct(
        private HomeMapper     $homeMapper,
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

    public function showAll(): Response
    {
        $homes = $this->homeRepository->findAllOrFail();

        return $this->render('homes.html.twig', [
            'homes' => $homes
        ]);
    }

    public function show(int $id): Response
    {
        $home = $this->homeRepository->findOrFail($id);

        return $this->render('home.html.twig', [
            'home' => $home
        ]);
    }

    public function create(): Response
    {
        return $this->render('form.html.twig');
    }

    public function store(): Response
    {
        $title = $this->request->postParameters['title'];
        $body = $this->request->postParameters['body'];

        $home = Home::create($title, $body);

        $id = $this->homeMapper->save($home);

        $this->request->getSession()->setFlash(
            'success',
            "Home successfully created with an id $id and a title $title"
        );

        return new RedirectResponse('/homes');
    }
}