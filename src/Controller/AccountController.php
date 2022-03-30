<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account", name="app_account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("/account/password", name="app_account_password")
     */
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        $successMessage = '';
        $errorMessage = '';

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if password (the old one) is correct
            $currentPassword = $form->get('old_password')->getData();
            if ($passwordHasher->isPasswordValid($user, $currentPassword)) {
                $newPassword = $form->get('new_password')->getData();
                $newPasswordHashed = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($newPasswordHashed);
                $this->entityManager->flush();
                $successMessage = 'Your password has been changed successfully!';
            } else {
                $errorMessage = 'Your current password is not correct!';
            }
        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'successMessage' => $successMessage,
            'errorMessage' => $errorMessage,
        ]);
    }
}
