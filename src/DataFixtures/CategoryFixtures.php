<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category_names = [
            'grabs',
            'rotations',
            'flips',
            'offset rotations',
            'slides',
            'one foot tricks',
            'old school',
        ];

        foreach ($category_names as $category_name)
        {
            $category  = new Category();
            $category->setName($category_name);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
