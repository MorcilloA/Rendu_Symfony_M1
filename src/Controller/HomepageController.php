<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index(CategoryRepository $categoryRepository):Response
    {

        $mainCats = $categoryRepository->findBy([
            "parent" => NULL
        ]);

        return $this->render('homepage/index.html.twig', [
            'mainCategories' => $mainCats,
        ]);
    }
}
