<?php
/**
 * Created by PhpStorm.
 * User: Rick
 * Date: 18/03/2022
 * Time: 14:28
 */

namespace App\Service\Cart;


use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CarteService
{
    protected $session;
    protected $producRepository;
    public function __construct(SessionInterface $session,ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->producRepository = $productRepository;
    }

    public function add(int $id){
        $panier = $this->session->get('panier',[]);

        if(!empty($panier[$id])){

            $panier[$id] ++;
        }else{
            $panier[$id] = 1;
        }

        $this->session->set('panier',$panier);
    }
    public function remove(int $id){
        $panier = $this->session->get('panier',[]);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $this->session->set('panier',$panier);
    }

    public function getFullCart(){
        $panier = $this->session->get('panier',[]);
        $panierWithData = [];
        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                "product"=>$this->producRepository->find($id),
                "quantity"=> $quantity,
            ];
        }
        return $panierWithData;
    }

    public function getTotal($panierWithData){
        $totalPrice = 0;

        foreach ($panierWithData as $item){
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $totalPrice += $totalItem;
        }
        return $totalPrice;
    }
}