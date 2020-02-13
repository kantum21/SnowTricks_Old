<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickFormType;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Sodium\add;

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
     * @Route("/tricks/edit/new", name="trick_new")
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param PictureRepository $pictureRepository
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request, SluggerInterface $slugger, PictureRepository $pictureRepository)
    {
        $form = $this->createForm(TrickFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            dd($form->getData());

            /** @var Trick $trick */
            $trick = $form->getData();

            //$trick->addPicture();
            //$trick->addVideo();

            $trick->setSlug($slugger->slug($trick->getName()));
            $trick->setCreatedAt(new \DateTime());
            $trick->setMainPicture($pictureRepository->findOneBy(['picture' => 'defaultTrick.jpg']));

            //persists flush redirect flash_message
        }


        return $this->render('trick/new.html.twig', [
            'trickForm' => $form->createView()
        ]);
    }
}
