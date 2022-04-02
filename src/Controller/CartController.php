<?php

namespace App\Controller;

use App\Library\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_cart")
     */
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFullCart(),
        ]);
    }

    /**
     * @Route("/cart/add/{productId}", name="app_cart_add_item")
     */
    public function addToCart($productId, Cart $cart): Response {
        $cart->addItem($productId);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/remove/{productId}/{completeRemove}", name="app_cart_remove_item")
     */
    public function removeFromCart($productId, $completeRemove = false,  Cart $cart): Response {
        $cart->removeItem($productId, $completeRemove);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/cart/empty", name="app_cart_empty")
     */
    public function emptyCart(Cart $cart): Response {
        $cart->emptyCart();
        return $this->redirectToRoute('app_cart');
    }
}
