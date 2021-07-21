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
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{username}", name="profile")
     */
    public function profile(EntityManagerInterface $manager, Security $security, string $username): Response
    {
        // test if is current user
        $isCurrentUser = $security->getUser()->getUserIdentifier() === $username;

        // get user by username
        $usersRepo = $manager->getRepository(User::class);
        $user = $usersRepo->findOneBy(["username" => $username]);

        // get categories
        $categoriesRepo = $manager->getRepository(Category::class);
        $categories = $categoriesRepo->findAll();

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
            'isCurrentUser' => $isCurrentUser,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/add-talent", name="add_talent")
     */
    public function addTalent(EntityManagerInterface $manager, Request $request): Response
    {
        // get current user
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var User $user */
        $user = $this->getUser();

        // get talent id
        $talentId = $request->query->get('talent');

        // get talent entity
        $talentsRepo = $manager->getRepository(Talent::class);
        /** @var Talent $talent */
        $talent = $talentsRepo->find($talentId);

        // add talent to user
        $user->addTalent($talent);

        // save changes
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('profile');
    }
}
