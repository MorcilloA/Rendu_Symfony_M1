<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\AbstractDataFixtures;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\AsciiSlugger;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        foreach( AbstractDataFixtures::CATEGORIES as $cat => $sub){
            $slugger = new AsciiSlugger();
            $mainCat = new Category();
            $mainCat
                ->setName($cat)
                ->setSlug($slugger->slug($cat));
            
            $manager->persist($mainCat);
            
            foreach ($sub as $subcats) {
                $subCat = new Category();
                $subCat
                    ->setName($subcats)
                    ->setSlug($slugger->slug($subcats))
                    ->setParent($mainCat);
                
                $manager->persist($subCat);

                // mise en memoire les entité pour pouvoir y acceder dans d'autres fixtures
                // addReference : 2 parametres
                //      identifiant unique de la référence
                //      entité liée à la référence
                $this->addReference("subcategory-$subcats", $subCat);
            }
        }
        
        $manager->flush();
    }
}
