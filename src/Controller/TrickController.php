<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickFormType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    /**
     * @Route("/tricks/edit/new", name="trick_edit_new")
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws Exception
     */
    public function new(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(TrickFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            dd($form->getData());

            /** @var Trick $trick */
            $trick = $form->getData();
            $trick->setSlug($slugger->slug($trick->getName()));
            $trick->setCreatedAt(new \DateTime());
            $entityManager->persist($trick);
            $entityManager->flush();
            $this->addFlash('success', 'Trick saved !');

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('trick/new.html.twig', [
            'trickForm' => $form->createView()
        ]);
    }
}
