<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $categoriesRepo = $manager->getRepository(Category::class);
        $categories = $categoriesRepo->findAll();

        return $this->render('index/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(EntityManagerInterface $manager): Response
    {
        $usersRepo = $manager->getRepository(User::class);
        $users = $usersRepo->findAll();

        $categoriesRepo = $manager->getRepository(Category::class);
        $categories = $categoriesRepo->findAll();

        return $this->render('index/search.html.twig', [
            'users' => $users,
            'categories' => $categories
        ]);
    }
}
