<?php

namespace App\Controller\Profile;

use App\Entity\Gif;
use App\Form\GifType;
use App\Repository\GifRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\ByteString;

class HomepageController extends AbstractController
{

    // private RequestStack $requestStack;
    // private Request $request;

    // public function __construct(RequestStack $requestStack)
    // {
    //     $this->requestStack = $requestStack;
    //     $this->request = $this->requestStack->getCurrentRequest();
    // }

    /**
     * @Route("/profile", name="profile.homepage.index")
     */
    public function index(): Response
    {
        return $this->render('profile/homepage/index.html.twig');
    }

    /**
     * @Route("/profile/form", name="profile.homepage.form", methods= {"GET", "POST"})
     */
    public function form(Request $request): Response
    {
        /*
            Il est recommandé de supprimer les typages sur les propriétés liées aux images pour utiliser 
        */

        $gif = new Gif();
        // Création du formulaire avec le type de formulaire et l'entité qui sera remplie ou modifiée
        $form = $this->createForm(GifType::class, $gif);

        // Récupération des données dans la requête HTTP
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $gif
                ->setUser($this->getUser());

            // Gestion de l'image
            // Création d'un nom aléatoire pour éviter les duplicats
            $imageName = ByteString::fromRandom(32)->lower();

            //Récupération de l'extension
            $imageExtension = $gif->getSource()->guessExtension();

            // Transfert de l'image
            //      move : méthode de UploadedFile qui permet de transférer l'image
            $gif->getSource()->move("images", $imageName . "." . $imageExtension);


            $gif
                ->setSource($imageName . "." . $imageExtension)
                ->setSlug($imageName . "." . $imageExtension)
            ;

            // dd($gif);
            
            $this->getDoctrine()->getManager()->persist($gif);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile.homepage.index');
        }

        return $this->render('profile/homepage/form.html.twig', [
            "gif" => $gif,
            "form" => $form->createView()
        ]);
    }

    
}
