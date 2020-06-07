<?php

namespace App\Controller;

use App\Entity\Factuur;
use App\Form\FactuurType;
use App\Repository\FactuurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/factuur")
 */
class FactuurController extends AbstractController
{
    /**
     * @Route("/", name="factuur_index", methods={"GET"})
     */
    public function index(FactuurRepository $factuurRepository): Response
    {
        return $this->render('factuur/index.html.twig', [
            'factuurs' => $factuurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="factuur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $factuur = new Factuur();
        $form = $this->createForm(FactuurType::class, $factuur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($factuur);
            $entityManager->flush();

            return $this->redirectToRoute('factuur_index');
        }

        return $this->render('factuur/new.html.twig', [
            'factuur' => $factuur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="factuur_show", methods={"GET"})
     */
    public function show(Factuur $factuur): Response
    {
        return $this->render('factuur/show.html.twig', [
            'factuur' => $factuur,
        ]);
    }

    /**
     * @Route("/pdf/{id}", name="factuur_pdf", methods={"GET"})
     */
    public function showPDF(Factuur $factuur)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial' );

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('/factuur/pdf.html.twig', [
            'factuur' => $factuur
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("factuur.pdf", [
            "Attachment" => false
        ]);


    }

    /**
     * @Route("/{id}/edit", name="factuur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Factuur $factuur): Response
    {
        $form = $this->createForm(FactuurType::class, $factuur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('factuur_index');
        }

        return $this->render('factuur/edit.html.twig', [
            'factuur' => $factuur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="factuur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Factuur $factuur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$factuur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($factuur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('factuur_index');
    }
}
