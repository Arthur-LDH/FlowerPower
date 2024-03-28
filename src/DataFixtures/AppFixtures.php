<?php

namespace App\DataFixtures;

use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Erp\CategoryErp;
use App\Entity\Erp\InvoiceErp;
use App\Entity\Erp\PricingErp;
use App\Entity\Erp\ProductErp;
use App\Entity\Orders\Orders;
use App\Entity\Orders\OrderPricingSellerOrErp;
use App\Entity\Orders\UsersOrders;
use App\Entity\Products\Image;
use App\Entity\Products\PricingSeller;
use App\Entity\Products\ProductBaseImage;
use App\Entity\Products\ProductSeller;
use App\Entity\Promotions\Promotion;
use App\Entity\Reviews\Review;
use App\Entity\Users\Address;
use App\Entity\Users\Seller;
use App\Entity\Users\Users;
use App\Entity\Users\UsersAddress;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

//===========================================
//              DATABASE USERS
//===========================================
        $user1 = new Users();
        //$user->setUuid($faker->uuid);
        $user1
            // ->setUuid($faker->uuid)
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setEmail($faker->email)
            ->setEmailVerifiedAt($faker->dateTime)
            ->setPassword(password_hash($faker->password, PASSWORD_DEFAULT))
            ->setRememberToken($faker->sha256)
            ->setBirthdate($faker->dateTime)
            ->setPhone($faker->phoneNumber)
            ->setRole($faker->randomElement(['user', 'admin', 'editor']))
            ->setCreatedAt($faker->dateTime)
            ->setUpdatedAt($faker->dateTime);

        $manager->persist($user1);

        $user2 = new Users();
        $user2
           // ->setUuid($faker->uuid)
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setEmail($faker->email)
            ->setEmailVerifiedAt($faker->dateTime)
            ->setPassword(password_hash($faker->password, PASSWORD_DEFAULT))
            ->setRememberToken($faker->sha256)
            ->setBirthdate($faker->dateTime)
            ->setPhone($faker->phoneNumber)
            ->setRole($faker->randomElement(['user']))
            ->setCreatedAt($faker->dateTime)
            ->setUpdatedAt($faker->dateTime);

        $manager->persist($user2);


        $address1 = new Address();
        $address1
            //->setUid($faker->uuid)
            ->setCoordinates(new Point($faker->latitude, $faker->longitude))
            ->setCreatedAt($faker->dateTime)
            ->setUpdatedAt($faker->dateTime);

        $manager->persist($address1);

        $address2 = new Address();
        $address2
            //->setUid($faker->uuid)
            ->setCoordinates(new Point($faker->latitude, $faker->longitude))
            ->setCreatedAt($faker->dateTime)
            ->setUpdatedAt($faker->dateTime);

        $manager->persist($address2);

        $userAddress = new UsersAddress();
        $userAddress
            //->setUserUid($faker->uuid)
            //->setAddressUid($faker->uuid)
            ->setLabel($faker->streetAddress)
            ->setFacturation($faker->boolean);

        $manager->persist($userAddress);

        $seller = new Seller();
        $seller
            //->setUid($faker->uuid);
            ->setNationalCode($faker->swiftBicNumber)
            ->setCompanyName($faker->company)
            ->setSellerName($faker->name)
            ->setPhone($faker->phoneNumber)
            ->setEmail($faker->companyEmail)
           // ->setUserUid($faker->uuid)
            //->setAddressUid($faker->uuid)
            ->setCreatedAt($faker->dateTime)
            ->setUpdatedAt($faker->dateTime);

        $manager->persist($seller);

        $manager->flush();

        $this->addReference('user 1', $user1);
        $this->addReference('users 2', $user2);
        $this->addReference('address 1', $address1);
        $this->addReference('address 2', $address2);
        $this->addReference('user address', $userAddress);
        $this->addReference('seller', $seller);

//===========================================
//              DATABASE REVIEWS
//===========================================

        $review = new Review();
        $review
           // ->setUid($faker->uuid)
            ->setComment($faker->realText($maxNbChars = 200, $indexSize = 2))
            ->setNote($faker->randomFloat($nbMaxDecimals = 1, $min = 0, $max = 5))
            ->setCreatedAt($faker->dateTime)
            //->setUserUid($faker->uuid)
            //->setProductUid($faker->uuid)
            ->setUpdatedAt($faker->dateTime);

        $manager->persist($review);

        $manager->flush();

        $this->addReference('review', $review);


//===========================================
//              DATABASE PROMOTIONS
//===========================================

        $promotion = new Promotion();
        $promotion
            ->setName($faker->words($nb = 2, $asText = true))
            ->setPercentage($faker->boolean)
            ->setDiscount($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL))
            ->setStartFrom($faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now'))
            ->setEndAt($faker->dateTimeBetween($startDate = 'now', $endDate = '+1 month'))
            ->setPromoCode($faker->regexify('[A-Z0-9]{10}'))
            ->setCreatedAt($faker->dateTime)
            ->setUpdatedAt($faker->dateTime);

        $manager->persist($promotion);


    // Associer à un vendeur de produits ou ERP
        $promotionProductSellerOrERP = new PromotionProductSellerOrERP();
        $promotionProductSellerOrERP
            ->setPromotionUid($promotion->getUid())
            ->setProductSellerOrErpUid($faker->uuid);

        $manager->persist($promotionProductSellerOrERP);

    // Associer à une catégorie
    //Pas encore créée
        //TODO
        $promotionCategory = new PromotionCategory();
        $promotionCategory
            ->setPromotionUid($promotion->getUid())
            ->setCategoryErpUid($faker->uuid);

        $manager->persist($promotionCategory);

        $manager->flush();

        $this->addReference('promotion', $promotion);
        $this->addReference('promotion product seller or erp', $promotionProductSellerOrERP);
        $this->addReference('promotion category', $promotionCategory);

//===========================================
//              DATABASE PRODUCTS
//===========================================

        $productSeller = new ProductSeller();
        $productSeller
            ->setUid($faker->uuid)
            ->setName($faker->word)
            ->setDescription($faker->paragraph)
            ->setSeasonalityStart($faker->dateTimeBetween('-2 months', '-1 month'))
            ->setSeasonalityEnd($faker->dateTimeBetween('+1 month', '+2 months'))
            ->setCreatedAt($faker->dateTimeBetween('-1 month', 'now'))
            ->setUpdatedAt($faker->dateTimeBetween('now', '+1 month'))
            ->setSellerUid($faker->uuid);

        $manager->persist($productSeller);

        $pricingSeller = new PricingSeller();
        $pricingSeller
            ->setUid($faker->uuid)
            ->setName($faker->word)
            ->setPrice($faker->randomFloat(2, 1, 1000))
            ->setTax($faker->randomFloat(2, 0, 20))
            ->setCreatedAt($faker->dateTimeBetween('-1 month', 'now'))
            ->setUpdatedAt($faker->dateTimeBetween('now', '+1 month'))
            ->setStockLeft($faker->numberBetween(0, 100))
            ->setStockMin($faker->numberBetween(0, 50))
            ->setProductSellerUid($faker->uuid);

        $manager->persist($pricingSeller);

        $image = new Image();
        $image
            ->setUid($faker->uuid)
            ->setPath($faker->imageUrl(640, 480, 'technics'))
            ->setName($faker->word)
            ->setAlternativeText($faker->sentence)
            ->setCreatedAt($faker->dateTimeBetween('-1 month', 'now'))
            ->setUpdatedAt($faker->dateTimeBetween('now', '+1 month'));

        $manager->persist($image);

        $productBaseImage = new ProductBaseImage();
        $productBaseImage
            ->setImageUid($faker->uuid)
            ->setProductUid($faker->uuid)
            ->setFront($faker->boolean);

        $manager->persist($productBaseImage);

        $manager->flush();

        $this->addReference('product seller', $productSeller);
        $this->addReference('pricing seller', $pricingSeller);
        $this->addReference('image', $image);
        $this->addReference('product base image', $productBaseImage);



//===========================================
//              DATABASE ORDERS
//===========================================

        $order = new Orders();
        $order
            ->setUid($faker->uuid)
            ->setStatus($faker->randomElement([0, 1, 2]))
            ->setPayedAt($faker->dateTimeBetween('-1 months', 'now'))
            ->setTotal($faker->randomFloat(2, 10, 1000))
            ->setCreatedAt($faker->dateTimeBetween('-2 months', '-1 months'))
            ->setUpdatedAt($faker->dateTime)
            ->setAddressUid($faker->uuid);

        $manager->persist($order);

        $userOrder = new UsersOrders();
        $userOrder
            ->setUserUid($faker->uuid)
            ->setOrderUid($faker->uuid)
            ->setPaymentIntent($faker->word)
            ->setAmount($faker->randomFloat(2, 10, 1000))
            ->setCreatedAt($faker->dateTimeBetween('-2 months', '-1 months'))
            ->setUpdatedAt($faker->dateTime);

        $manager->persist($userOrder);

        $orderPricingSellerOrErp = new OrderPricingSellerOrErp();
        $orderPricingSellerOrErp
            ->setProductSellerOrErpUid($faker->uuid)
            ->setOrderUid($faker->uuid)
            ->setQuantity($faker->numberBetween(1, 100));

        $manager->persist($orderPricingSellerOrErp);

        $manager->flush();
        $this->addReference('order', $order);
        $this->addReference('user order', $userOrder);
        $this->addReference('order pricing seller or erp', $orderPricingSellerOrErp);


//===========================================
//              DATABASE ERP
//===========================================

        $categoryErp = new CategoryErp();
        $categoryErp
            ->setUid($faker->uuid)
            ->setName($faker->word);

        $manager->persist($categoryErp);

        $productErp = new ProductErp();
        $productErp
            ->setUid($faker->uuid)
            ->setName($faker->sentence(2))
            ->setDescription($faker->text)
            ->setSeasonalityStart($faker->dateTimeBetween('now', '+1 month'))
            ->setSeasonalityEnd($faker->dateTimeBetween('+1 month', '+6 months'))
            ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'))
            ->setUpdatedAt($faker->dateTimeBetween('now', '+1 year'));

        $manager->persist($productErp);

        $pricingErp = new PricingErp();
        $pricingErp
            ->setUid($faker->uuid)
            ->setName($faker->word)
            ->setPrice($faker->randomFloat(2, 10, 1000))
            ->setTax($faker->randomFloat(2, 0, 20))
            ->setCreatedAt($faker->dateTimeBetween('-1 year', 'now'))
            ->setUpdatedAt($faker->dateTimeBetween('now', '+1 year'))
            ->setStockLeft($faker->numberBetween(0, 100))
            ->setStockMin($faker->numberBetween(0, 50))
            ->setProductErpUid($faker->uuid);

        $manager->persist($pricingErp);

        $invoiceErp = new InvoiceErp();
        $invoiceErp
            ->setUid($faker->uuid)
            ->setOrderUid($faker->regexify('[A-Za-z0-9]{32}'))
            ->setSellerUid($faker->uuid);

        $manager->persist($invoiceErp);

        $categoryErpProductErp = new CategoryErpProductErp();
        $categoryErpProductErp
            ->setCategoryErpUid($faker->uuid)
            ->setProductErpUid($faker->uuid);

        $manager->persist($categoryErpProductErp);

        $manager->flush();

        $this->addReference('category Erp', $categoryErp);
        $this->addReference('Product Erp', $productErp);
        $this->addReference('Pricing  Erp', $pricingErp);
        $this->addReference('Invoice Erp', $invoiceErp);
        $this->addReference('category Erp Product Erp', $categoryErpProductErp);
    }
}
