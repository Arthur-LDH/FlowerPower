<?php

namespace App\Controller;

use App\Entity\Orders\Order;
use App\Entity\Users\Address;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager('default');
        $address = new Address();
        $address->setNumber('Hello');
        $entityManager->persist($address);
        $entityManager->flush();

        $orderEntityManager = $doctrine->getManager('orders');
        $order = new Order();
        $order->setName('order1');
        $orderEntityManager->persist($order);
        $orderEntityManager->flush();


        dd($order, $address);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
