<?php

namespace App\Controller;

use App\Form\PictureFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    /**
     * @Route("/pictures/edit/new", name="picture_new")
     */
    public function new()
    {
        $form = $this->createForm(PictureFormType::class);

        return $this->render('picture/new.html.twig', [
            'pictureForm' => $form->createView()
        ]);
    }
}
