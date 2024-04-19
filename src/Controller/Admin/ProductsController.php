<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ArgumentResolver\EntityValueResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/admin/produits', name: 'app_admin_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('admin/products/index.html.twig');
    }
    #[Route('/ajout', name: 'app_admin_add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // on crée un nouveau produit
        $product = new Products();

        // creation du formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        //on traite la requete du formulaire
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {

            // generation du slug

            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);



            // stockage dans la base de donnée

            $em->persist($product);
            $em->flush();

            $this->addFlash('succes', 'Produit ajouté avec succès');

            // Redirection

            // return $this->redirectToRoute('');
        }

        return $this->render('admin/products/add.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'app_admin_edit')]
    public function edit(Products $product, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {

        // on verifie si l'utilisateur peu editer


        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

        // Création du formulaire 

        $productForm = $this->createForm(ProductsFormType::class, $product);

        // traitement de la requête d'édition, 

        $productForm->handleRequest($request);


        if ($productForm->isSubmitted() && $productForm->isValid()) {

            // generation du slug

            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);



            // stockage dans la base de donnée

            $em->persist($product);
            $em->flush();

            $this->addFlash('succes', 'Produit ajouté avec succès');

            // Redirection

            // return $this->redirectToRoute('');
        }

        return $this->render('admin/products/edit.html.twig');
    }
    #[Route('/delete/{id}', name: 'app_admin_delete')]
    public function delete(Products $product): Response
    {
        //on verifie si l'utilisateur peu supprimer
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $product);
        return $this->render('admin/products/index.html.twig');
    }
}
