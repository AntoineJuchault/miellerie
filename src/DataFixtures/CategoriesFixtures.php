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
        // Création de la catégorie parente
        $parent = new Categories();
        $parent->setName('Informatique');
        $parent->setSlug($this->slugger->slug($parent->getName())); // Définition du slug
        $manager->persist($parent);
        
        // Création de la catégorie enfant
        $category = new Categories();
        $category->setName('Ordinateur-portable');
        $category->setSlug($this->slugger->slug($category->getName())); // Utilisation du nom de la catégorie enfant pour le slug
        $category->setParent($parent); // Définition de la relation parent-enfant
        $manager->persist($category);
        
        $manager->flush();
    }
}