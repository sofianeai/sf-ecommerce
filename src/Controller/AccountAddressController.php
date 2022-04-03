<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account/addresses", name="app_account_addresses")
     */
    public function index(): Response
    {
        return $this->render('account/addresses.html.twig');
    }

    /**
     * @Route("/account/addresses/add", name="app_account_addresses_add")
     */
    public function add(Request $request): Response {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_addresses');
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit user address
     * 
     * Symfony will automatically bind the right $address object with the param {id}.
     * 
     * @Route("/account/addresses/edit/{id}", name="app_account_addresses_edit")
     */
    public function edit(Address $address, Request $request): Response {
        if ($address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account');
        }
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_addresses');
        }
        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/account/addresses/delete/{id}", name="app_account_addresses_delete")
     */
    public function delete(Address $address): Response {
        if ($address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account');
        }
        $this->entityManager->remove($address);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_account_addresses');
    }
}
