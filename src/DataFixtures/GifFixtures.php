<?php

namespace App\DataFixtures;

use App\Entity\Gif;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class GifFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies():array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class
        ];
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        $slugger = new AsciiSlugger();
        
        foreach(AbstractDataFixtures::CATEGORIES as $cat => $subCategories){
            foreach ($subCategories as $subCat) {
                $gif = new Gif();
                $gif
                ->setSource($slugger->slug($subCat)->lower() . '.gif')
                ->setSlug($slugger->slug($subCat)->lower())
                ->setCategory($this->getReference("subcategory-$subCat"))
                ->setUser($this->getReference("user"))
                ;
                
                $manager->persist($gif);
            }
        }

        $manager->flush();
    }
}
