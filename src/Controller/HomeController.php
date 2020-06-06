<?php

namespace App\Controller;

use App\Repository\ProductImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/shop", name="home")
     */
    public function shop(ProductRepository $productRepository, ProductImageRepository $productImageRepository): Response
    {
        return $this->render('home/shop.html.twig', [
            'product' => $productRepository->findAll(),
            'images' => $productImageRepository->findAll()
        ]);
    }
}
