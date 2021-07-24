<?php

namespace App\Controller;

use App\Entity\Category;
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
}
