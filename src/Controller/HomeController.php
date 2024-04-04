<?php

namespace App\Controller;

use App\Entity\Erp\CategoryErp;
use App\Entity\Erp\ProductErp;
use App\Entity\Orders\Orders;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager('orders');

        $order = $entityManager->getRepository(Orders::class)->find('1eef2603-083c-62aa-972d-e157a203f74b');

//        $entityManager->flush();
        dd($entityManager->getRepository(Orders::class)->calculateTotalOrder($order->getOrderPricingSellerOrErps()));
        dd($order->getOrderPricingSellerOrErps()[1]->setManagerRegistry($doctrine)->getPricing());

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
