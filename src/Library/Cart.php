<?php

namespace App\Library;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Exposes methods to manipulate a cart saved in the session.
 * 
 * 🚨 Maybe set all properties and methods to be static.
 */
class Cart
{
    private $requestStack;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    /**
     * Get cart content with all products properties, total cart amount and total cart items.
     * For each product is also associated a quantity.
     */
    public function getFullCart()
    {
        $cartItems = $this->getCartFromSession();
        $products = $this
            ->entityManager
            ->getRepository(Product::class)
            ->findByIds(array_keys($cartItems))
        ;
        $nbCartItems = 0;
        $totalCartAmount = 0;
        foreach ($products as $key => $product) {
            $quantity = $cartItems[$product->getId()];
            $nbCartItems += $quantity;
            $totalCartAmount += number_format($product->getPrice() / 100, 2) * $quantity;
            $product->quantity = $quantity;
        }
        $fullCart = new stdClass();
        $fullCart->nbItems =  $nbCartItems;
        $fullCart->totalAmount = $totalCartAmount;
        $fullCart->products = $products;
        return $fullCart;
    }

    /**
     * Get cart content stored in the session, 
     * which consists of an array [productId => quantity].
     * 
     * @return array
     */
    public function getCartFromSession()
    {
        return $this->requestStack->getSession()->get('cart', []);
    }

    /**
     * Add an item to the cart.
     * 
     * @param int $id
     */
    public function addItem($id)
    {
        $cart = $this->getCartFromSession();

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $this->requestStack->getSession()->set('cart', $cart);
    }

    /**
     * Removes an item from the cart.
     * 
     * - If $completeRemove is false, the item's quantity is decreased
     * - If $completeRemove is true, the item is removed completely from the cart.
     * 
     * @param int $id
     */
    public function removeItem($id, $completeRemove = false)
    {
        $cart = $this->getCartFromSession();

        if (!empty($cart[$id])) {
            $cart[$id]--;
            if ($cart[$id] <= 0 or $completeRemove) {
                unset($cart[$id]);
            }
        }

        $this->requestStack->getSession()->set('cart', $cart);
    }

    /**
     * Remove cart entry from the session
     */
    public function emptyCart()
    {
        $this->requestStack->getSession()->remove('cart');
    }
}
