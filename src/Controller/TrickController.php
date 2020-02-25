<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\SelectPictureFormType;
use App\Form\TrickFormType;
use App\Repository\PictureRepository;
use App\Repository\TrickRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
     * @param SessionInterface $session
     * @param SluggerInterface $slugger
     * @param PictureRepository $pictureRepository
     * @return Response
     * @throws Exception
     */
    public function new(Request $request,SessionInterface $session, SluggerInterface $slugger, PictureRepository $pictureRepository)
    {
        $trick = (!$session->get('trick')) ? new Trick() : $session->get('trick');
        $session->set('trick', $trick);
        $form = $this->createForm(TrickFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            dd($form->getData());

            /** @var Trick $trick */
            $trick = $form->getData();

            //$trick->addPicture();
            //$trick->addVideo();
            $trick->setMainPicture($pictureRepository->findOneBy(['picture' => 'defaultTrick.jpg']));

            $trick->setSlug($slugger->slug($trick->getName()));
            $trick->setCreatedAt(new \DateTime());

            //persists flush redirect flash_message
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'trickForm' => $form->createView()
        ]);
    }

    /**
     * @Route ("tricks/edit/mainPicture", name="trick_edit_main_picture")
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    public function editMainPicture(Request $request, SessionInterface $session)
    {
        $form = $this->createForm(SelectPictureFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Trick $trick */
            $trick = (!$session->get('trick')) ? new Trick() : $session->get('trick');
            $trick->setMainPicture($form->get('picture')->getData());
            $session->set('trick', $trick);

            return $this->redirectToRoute('trick_edit_new');
        }

        return $this->render('trick/selectPicture.html.twig', [
            'selectPictureForm' => $form->createView()
        ]);
    }

    /**
     * @Route("tricks/edit/deleteMainPicture", name="trick_edit_delete_main_picture")
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function deleteMainPicture(SessionInterface $session)
    {
        /** @var Trick $trick */
        $trick = (!$session->get('trick')) ? new Trick() : $session->get('trick');
        $trick->setMainPicture(null);
        $session->set('trick', $trick);

        return $this->redirectToRoute('trick_edit_new');
    }

    /**
     * @Route("tricks/edit/addPicture", name="trick_edit_add_picture")
     * @param Request $request
     * @param SessionInterface $session
     * @return RedirectResponse|Response
     */
    public function addPicture(Request $request, SessionInterface $session)
    {
        $form = $this->createForm(SelectPictureFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Trick $trick */
            $trick = (!$session->get('trick')) ? new Trick() : $session->get('trick');
            $trick->addPicture($form->get('picture')->getData());
            $session->set('trick', $trick);

            return $this->redirectToRoute('trick_edit_new');
        }

        return $this->render('trick/selectPicture.html.twig', [
            'selectPictureForm' => $form->createView()
        ]);
    }
}
