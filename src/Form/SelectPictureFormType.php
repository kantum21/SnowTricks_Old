<?php

namespace App\Form;

use App\Controller\PictureController;
use App\Entity\Picture;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SelectPictureFormType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('picture', EntityType::class, [
                'label' => 'Select a picture',
                'class' => Picture::class,
                'expanded' => true,
                'choice_label' => 'picture',
                'data' => $this->entityManager->getRepository(Picture::class)->findOneBy(['picture' => 'defaultTrick.jpg']),
                    /*
                    function(Picture $picture) {
                    $pictureController =  new PictureController();
                    return $pictureController->show($picture);
                    }
                    */
            ])
            ->add('select', SubmitType::class);
    }
}
