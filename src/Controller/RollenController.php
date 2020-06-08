<?php

namespace App\Controller;

use App\Entity\Rollen;
use App\Form\RollenType;
use App\Repository\RollenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rollen")
 */
class RollenController extends AbstractController
{
    /**
     * @Route("/", name="rollen_index", methods={"GET"})
     */
    public function index(RollenRepository $rollenRepository): Response
    {
        return $this->render('rollen/index.html.twig', [
            'rollens' => $rollenRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rollen_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rollen = new Rollen();
        $form = $this->createForm(RollenType::class, $rollen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rollen);
            $entityManager->flush();

            return $this->redirectToRoute('rollen_index');
        }

        return $this->render('rollen/new.html.twig', [
            'rollen' => $rollen,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rollen_show", methods={"GET"})
     */
    public function show(Rollen $rollen): Response
    {
        return $this->render('rollen/show.html.twig', [
            'rollen' => $rollen,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rollen_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rollen $rollen): Response
    {
        $form = $this->createForm(RollenType::class, $rollen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rollen_index');
        }

        return $this->render('rollen/edit.html.twig', [
            'rollen' => $rollen,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rollen_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rollen $rollen): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rollen->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rollen);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rollen_index');
    }
}
