<?php

namespace App\controller;

use allbertss\psittacorum\controller\AbstractController;
use allbertss\psittacorum\http\RedirectResponse;
use allbertss\psittacorum\http\Response;
use App\form\user\RegistrationForm;

class RegisterController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('register.html.twig');
    }

    public function register(): Response
    {
        $form = new RegistrationForm();

        $form
            ->setUsername($this->request->input('username'))
            ->setPassword($this->request->input('password'));

        if ($form->hasValidationErrors()) {
            foreach ($form->getValidationErrors() as $error) {
                $this->request->getSession()->setFlash('error', $error);
            }

            return new RedirectResponse('/register');
        }
    }
}