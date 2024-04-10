<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Trait\SlugTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}
    public function load(ObjectManager $manager): void
    {
        // Création de la catégorie parente Miel
        $parent1 = new Categories();
        $parent1->setName('Miel');
        $parent1->setSlug($this->slugger->slug($parent1->getName())); // Définition du slug
        $manager->persist($parent1);
        
        // Création de la catégorie parente Produit à base de miel
        $parent2 = new Categories();
        $parent2->setName('Produit à base de miel');
        $parent2->setSlug($this->slugger->slug($parent2->getName())); // Définition du slug
        $manager->persist($parent2);

        // Création de la catégorie enfant Miel crémeux sous la catégorie parente Miel
        $category = new Categories();
        $category->setName('Miel crémeux');
        $category->setSlug($this->slugger->slug($category->getName())); // Utilisation du nom de la catégorie enfant pour le slug
        $category->setParent($parent1); // Définition de la relation parent-enfant
        $manager->persist($category);

        $manager->flush();
    }
}