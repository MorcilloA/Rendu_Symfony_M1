<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="category.index")
     */
    public function index(string $slug, CategoryRepository $categoryRepository):Response
    {
        $category = $categoryRepository->findOneBy([
            "slug" => $slug
        ]);
        $subCategories= $categoryRepository->getSubCategoriesByMainCategorySlug($slug)->getResult();

        // dd($subCategories);
        return $this->render('category/index.html.twig', [
            'subCategories' => $subCategories,
            'category' => $category
        ]);
    }

    /**
     * @Route("/category/{categorySlug}/{subCategorySlug}", name="category.subCategory")
     */
    public function subCategory(string $categorySlug, string $subCategorySlug, CategoryRepository $categoryRepository):Response
    {
        //récupérer la sous-catégorie dans la BDD
        $subCategory = $categoryRepository->findOneBy([
            'slug' => $subCategorySlug
        ]);
        
        $gifs = $subCategory->getGifs();

        return $this->render('category/subcategory.html.twig', [
            'subCategory' => $subCategory,
            'gifs' => $gifs
        ]);
    }
}
