<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\SearchType;
use App\Library\Search;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/products", name="app_products")
     */
    public function index(Request $request): Response
    {
        $search = new Search();
        // Create the filters form
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        } else {
            $products = $this->entityManager->getRepository(Product::class)->findAll();
        }
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/products/{slug}", name="app_product")
     */
    public function product(string $slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }
}
