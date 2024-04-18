<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produits', name: 'app_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ProductsRepository $productsRepository): Response
        {
            $products = $productsRepository->findAll();
            
        return $this->render('products/index.html.twig', 
        ['products' => $products ]);
    }
    #[Route('/{slug}', name: 'app_details')]
        public function details(Products $product): Response
    {
        return $this->render('products/details.html.twig', compact('product'));
    }
}
