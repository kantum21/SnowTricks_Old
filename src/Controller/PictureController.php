<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureFormType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    /**
     * @Route("/pictures/edit/new", name="picture_new")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader)
    {
        $form = $this->createForm(PictureFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var Picture $picture */
            $picture = $form->getData();
            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('picture')->getData();
            if ($pictureFile)
            {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $picture->setPicture($pictureFileName);
            }
            $entityManager->persist($picture);
            $entityManager->flush();
            $this->addFlash('success', 'Picture saved !');

            return $this->redirectToRoute('trick_new');
        }

        return $this->render('picture/new.html.twig', [
            'pictureForm' => $form->createView()
        ]);
    }
}
