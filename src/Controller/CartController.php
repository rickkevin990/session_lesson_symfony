<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart\CarteService;
use function PHPUnit\Framework\isEmpty;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(CarteService $carteService): Response
    {

        $panierWithData = $carteService->getFullCart();

        $totalPrice = $carteService->getTotal($panierWithData);

        return $this->render('cart/index.html.twig', [
            'items' =>$panierWithData,
            'total'=> $totalPrice
        ]);
    }

    /**
     * @Route("/pannier/add/{id}", name="add_panier")
     */
    public function add($id,CarteService $carteService): Response
    {
        $carteService->add($id);
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/pannier/remove/{id}", name="remove_panier")
     */
    public function remove($id,CarteService $carteService)
    {
          $carteService->remove($id);
          return $this->redirectToRoute("cart_index");
    }


}
