<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Form\ProductsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/produits', name: 'app_admin_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('admin/products/index.html.twig');
    }
    #[Route('/ajout', name: 'app_admin_add')]
    public function add(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // on crée un nouveau produit
        $product = new Products();
        
        // creation du formulaire

        $productform = $this->createForm(ProductsFormType::class, $product);
        
        
        return $this->render('admin/products/add.html.twig', [
            'productform' => $productform -> createView()
        ]);


    }
    
    #[Route('/edit/{id}', name: 'app_admin_edit')]
    public function edit(Products $product): Response
    {
        // on verifie si l'utilisateur peu editer
        $this->denyAccessUnlessGranted('PRODUCT_EDIT',$product);
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/delete/{id}', name: 'app_admin_delete')]
    public function delete(Products $product): Response
    {
        //on verifie si l'utilisateur peu supprimer
        $this->denyAccessUnlessGranted('PRODUCT_DELETE',$product);
        return $this->render('admin/products/index.html.twig');
    }

}