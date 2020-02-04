<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     * @param TrickRepository $trickRepository
     * @return Response
     */
    public function homepage(TrickRepository $trickRepository)
    {
        $tricks = $trickRepository->findAllOrderedByCreatedAt();
        return $this->render('trick/homepage.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/tricks/details/{slug}", name="trick_show")
     * @param $slug
     * @param Trick $trick
     * @return Response
     */
    public function show($slug, Trick $trick)
    {
        return $this->render('trick/show.html.twig', [
           'trick' => $trick
        ]);
    }
}
