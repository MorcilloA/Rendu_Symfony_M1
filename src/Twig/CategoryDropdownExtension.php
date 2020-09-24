<?php

namespace App\Twig;

use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CategoryDropdownExtension extends AbstractExtension
{

    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    // public function getFilters(): array
    // {
    //     return [
    //         // If your filter generates SAFE HTML, you should add a third
    //         // parameter: ['is_safe' => ['html']]
    //         // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
    //         new TwigFilter('filter_name', [$this, 'doSomething']),
    //     ];
    // }
    
    /*
        getFunctions : créer une fonction personnalisée dans twig
    */
    public function getFunctions(): array
    {
        /*
            paramètres :
                nom de la fonction dans twig
                nom de la méthode php reliée à la fonction
        */
        return [
            new TwigFunction('get_categories', [$this, 'getCategories']),
        ];
    }

    public function getCategories():array
    {
        // $categories = $this->categoryRepository->findBy(
        //     array(
        //         "parent" => NULL
        //     ),
        //     array(
        //         'parent' => 'ASC'
        //     )
        // );
        
        $categories = $this->categoryRepository->findAll();
        // $orderedCategories = array();
        // foreach ($categories as $category) {
        //     $subcats = $this->categoryRepository->findBy(
        //         array(
        //             "parent" => $category->getId()
        //         )
        //     );
        //     $orderedCategories[$category->getName()] = $subcats;
        // }


        // dd($orderedCategories);

        return $categories;
        // return $orderedCategories;

    }
}
