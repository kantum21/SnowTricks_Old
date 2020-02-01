<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PictureFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $picture = new Picture();
        $picture->setPicture('defaultTrick.jpg');
        $picture->setAlt('jump');
        $manager->persist($picture);
        $this->addReference('Picture' . '_' . 0, $picture);

        $manager->flush();
    }
}
