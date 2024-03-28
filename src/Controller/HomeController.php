<?php

namespace App\Controller;

use App\Entity\Erp\CategoryErp;
use App\Entity\Erp\ProductErp;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager('erp');
        $category = new CategoryErp();
        $category->setName('Test');
        $entityManager->persist($category);

        $product = new ProductErp();
        $product->setName('Product Test');
        $product->setDescription('Test');
        $product->setSeasonalityStart(new \DateTime('now'));
        $product->setSeasonalityEnd(new \DateTime('now'));

        $entityManager->flush();
        dd($category, $product);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
