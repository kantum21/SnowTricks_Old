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

    //TODO : use slug ?
    /**
     * @Route("/ticks/{id}", name="trick_show")
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function show($id, EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Trick::class);
        /** @Var Trick $trick */
        $trick = $repository->findOneBy(['id' => $id]);
        if (!$trick)
        {
            throw $this->createNotFoundException(sprintf('No trick for id "%d"', $id));
        }

        return $this->render('trick/show.html.twig', [
           'trick' => $trick
        ]);
    }
}
