<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class PageController.
 *
 * This is the controller for pages
 */
#[Route(name: 'app_home_')]
class Page extends AbstractController
{
    /**
     * Action Cart.
     *
     * This is Cart page controller
     */
    #[Route('/cart', name: 'cart')]
    public function cart(): Response
    {
        $title = "Cart";

        return $this->render('page/cart.html.twig', ['title' => $title]);
    }

    /**
     * Action Checkout.
     *
     * This is Checkout page controller
     */
    #[Route('/checkout', name: 'checkout')]
    public function checkout(): Response
    {
        $title = "Checkout";

        return $this->render('page/checkout.html.twig', ['title' => $title]);
    }

    /**
     * Action Wishlist.
     *
     * This is Wishlist page controller
     */
    #[Route('/wishlist', name: 'wishlist')]
    public function wishlist(): Response
    {
        $title = "Wishlist";

        return $this->render('page/wishlist.html.twig', ['title' => $title]);
    }

    /**
     * Action Contact Us.
     *
     * This is Contact Us page controller
     */
    #[Route('/contact-us', name: 'contact_us')]
    public function contact(): Response
    {
        $title = "Contact Us";

        return $this->render('page/contact_us.html.twig', ['title' => $title]);
    }

    /**
     * Action About Us.
     *
     * This is About Us page controller
     */
    #[Route('/about-us', name: 'about_us')]
    public function about(): Response
    {
        $title = "About Us";

        return $this->render('page/about_us.html.twig', ['title' => $title]);
    }

    /**
     * Action 404.
     *
     * This is 404-page controller
     */
    #[Route('/404', name: '404')]
    public function page404(): Response
    {
        $title = "Page Not Found";

        return $this->render('page/404.html.twig', ['title' => $title]);
    }

    /**
     * Action forgot password.
     *
     * This is Forgot password page controller
     */
    #[Route('/forgot-password', name: 'forgot_password')]
    public function forgotPassword(): Response
    {
        $title = "Forgot Password";

        return $this->render('page/forgot_password.html.twig', ['title' => $title]);
    }

    /**
     * Action shop.
     *
     * This is shop page controller
     */
    #[Route('/shop', name: 'shop')]
    public function shop(): Response
    {
        $title = "Shop";

        return $this->render('page/shop.html.twig', ['title' => $title]);
    }

    /**
     * Action Product Details.
     *
     * This is Product Details page controller
     */
    #[Route('/product-details', name: 'product_details')]
    public function productDetails(): Response
    {
        $title = "Product Details";

        return $this->render('page/product_details.html.twig', ['title' => $title]);
    }

    /**
     * Action Product Compare.
     *
     * This is Product Details page controller
     */
    #[Route('/product-compare', name: 'product_compare')]
    public function productCompare(): Response
    {
        $title = "Product Compare";

        return $this->render('page/product_compare.html.twig', ['title' => $title]);
    }
}
