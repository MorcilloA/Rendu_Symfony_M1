<?php

namespace App\Controller;

use App\Entity\Gif;
use App\Repository\GifRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\String\ByteString;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GifController extends AbstractController
{
    /**
     * @Route("/gif/{gifSlug}", name="gif.index")
     */
    public function index(string $gifSlug, GifRepository $gifRepository)
    {

        $gif = $gifRepository->findOneBy([
            'slug' => $gifSlug
        ]);

        // dd($gif);
        return $this->render('gif/index.html.twig', [
            'gif' => $gif
        ]);
    }

    /**
     * @Route("/gif/{gifSlug}/edit", name="gif.edit")
     */
    public function edit(string $gifSlug, GifRepository $gifRepository, Gif $gif, Request $request)
    {

        $form = $this->createForm(GifType::class, $gif);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageName = ByteString::fromRandom(32)->lower();
            $imageExtension = $gif->getSource()->guessExtension();

            $gif->getSource()->move("images", $imageName . "." . $imageExtension);


            $gif
                ->setSource($imageName . "." . $imageExtension)
                ->setSlug($imageName . "." . $imageExtension)
            ;

            dd($gif);
            
            $this->getDoctrine()->getManager()->persist($gif);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile.homepage.index');
        }

        
        return $this->render('gif/edit.html.twig', [
            'gif' => $gif,
            'form' => $form
        ]);
    }
}
