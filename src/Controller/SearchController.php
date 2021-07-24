<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Talent;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(EntityManagerInterface $manager, Request $request): Response
    {
        $categoriesRepo = $manager->getRepository(Category::class);
        $categories = $categoriesRepo->findBy(['parent' => NULL]);

        $usersRepo = $manager->getRepository(User::class);
        $users = $usersRepo->findAll();

        // get query params
        $categoryId = $request->query->get('category');
        $talentId = $request->query->get('talent');

        if ($talentId) {
            $talentsRepo = $manager->getRepository(Talent::class);
            /** @var Talent $talent */
            $talent = $talentsRepo->find($talentId);
            $users = $talent->getUsers();
        }

        return $this->render('search/search.html.twig', [
            'categories' => $categories,
            'users' => $users
        ]);
    }
}
