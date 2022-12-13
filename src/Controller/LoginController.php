<?php

namespace App\Controller;

use App\Entity\Login;
use App\Form\LoginType;
use App\Repository\LoginRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/login")
 */
class LoginController extends AbstractController
{
    /**
     * @Route("/", name="app_login_index", methods={"GET"})
     */
    public function index(LoginRepository $loginRepository): Response
    {
        return $this->render('login/index.html.twig', [
            'logins' => $loginRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_login_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LoginRepository $loginRepository): Response
    {
        $login = new Login();
        $form = $this->createForm(LoginType::class, $login);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loginRepository->add($login, true);

            return $this->redirectToRoute('app_login_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('login/new.html.twig', [
            'login' => $login,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_login_show", methods={"GET"})
     */
    public function show(Login $login): Response
    {
        return $this->render('login/show.html.twig', [
            'login' => $login,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_login_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Login $login, LoginRepository $loginRepository): Response
    {
        $form = $this->createForm(LoginType::class, $login);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loginRepository->add($login, true);

            return $this->redirectToRoute('app_login_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('login/edit.html.twig', [
            'login' => $login,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_login_delete", methods={"POST"})
     */
    public function delete(Request $request, Login $login, LoginRepository $loginRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$login->getId(), $request->request->get('_token'))) {
            $loginRepository->remove($login, true);
        }

        return $this->redirectToRoute('app_login_index', [], Response::HTTP_SEE_OTHER);
    }
}
