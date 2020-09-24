<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search.index", methods = {"POST"})
     */
    public function index(Request $request, CategoryRepository $categoryRepository)
    {

        $categories = $categoryRepository->getCategoriesByNamePart($request->request->get("search"))->getResult();
        $supCategories = array();
        // dump($request->request->get("search"));
        // dump($categories);

        foreach ($categories as $category) {
            //Si c'est un parent
            if ($category->getParent() == null) {
                //Récupérer toutes les sous-catégories
                $subCats = $categoryRepository->findBy([
                    "parent" => $category->getId()
                ]);
                //Créer une case au tableau contenant un tableau de toutes les sous-catégories
                $supCategories[$category->getName()] = $subCats;

                //supprimer l'entité de catégorie principale du tableau d'origine
                unset($categories[array_search($category->getName(), $categories)]);
                
                //On parcourt le tableau des sous-catégories
                foreach ($supCategories[array_key_last($supCategories)] as $subCategory) {
                    //Si elle existe dans le tableau d'origine
                    if(array_search($subCategory, $categories)){
                        //On la supprime pour évider de les retrouver 2 fois (une fois dans le tableau de départ et une fois dans un tableau de sous-catégories)
                        unset($categories[array_search($subCategory, $categories)]);
                    }
                }
                
            }
        }
        // dd(array_reverse($categories));


        return $this->render('search/index.html.twig', [
            'supCategories' => $supCategories,
            'categories' => array_reverse($categories),
            'search' => $request->request->get("search")
        ]);
    }
}
