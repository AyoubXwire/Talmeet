<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            1 => [
                'name' => 'Music',
                'icon' => 'Icon'
            ],
            2 => [
                'name' => 'Sport',
                'icon' => 'Icon'
            ],
            3 => [
                'name' => 'Acting',
                'icon' => 'Icon'
            ],
            4 => [
                'name' => 'Design',
                'icon' => 'Icon'
            ],
        ];

        foreach($categories as $key => $value) {
            $category = new Category();
            $category->setName($value['name']);
            $category->setIcon($value['icon']);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
