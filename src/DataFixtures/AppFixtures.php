<?php

namespace App\DataFixtures;

use App\Entity\Products\CategoryErpProductSeller;
use App\Entity\Promotions\PromotionCategory;
use App\Entity\Promotions\PromotionProductSellerOrErp;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Erp\CategoryErp;
use App\Entity\Erp\PricingErp;
use App\Entity\Erp\ProductErp;
use App\Entity\Products\Image;
use App\Entity\Products\PricingSeller;
use App\Entity\Products\ProductSellerImage;
use App\Entity\Products\ProductSeller;
use App\Entity\Promotions\Promotion;
use App\Entity\Reviews\Review;
use App\Entity\Users\Address;
use App\Entity\Users\Seller;
use App\Entity\Users\Users;
use App\Entity\Users\UsersAddress;
use App\Entity\Orders\Orders;
use App\Entity\Orders\OrderPricingSellerOrErp;
use App\Entity\Orders\UsersOrders;
use App\Entity\Erp\InvoiceErp;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public function __construct(private readonly ManagerRegistry $doctrine)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $usersManager = $this->doctrine->getManager('default');
        $productsManager = $this->doctrine->getManager('products');
        $erpManager = $this->doctrine->getManager('erp');
        $promotionsManager = $this->doctrine->getManager('promotions');
        $reviewsManager = $this->doctrine->getManager('reviews');
        $ordersManager = $this->doctrine->getManager('orders');

////===========================================
////             Users
//// 100 users + address pour chaque
////===========================================
//        for ($i = 1; $i <= 50; $i++) {
//            $user = new Users();
//            $user
//                ->setFirstname($faker->firstName)
//                ->setLastname($faker->lastName)
//                ->setEmail($faker->email)
//                ->setEmailVerifiedAt($faker->dateTime)
//                ->setPassword(password_hash($faker->password, PASSWORD_DEFAULT))
//                ->setOldPassword(password_hash($faker->password, PASSWORD_DEFAULT))
//                ->setRememberToken($faker->sha256)
//                ->setBirthdate($faker->dateTime)
//                ->setPhone("0649956639")
//                ->setRole($faker->randomElement([['user'], ['admin'], ['editor']]));
//            $usersManager->persist($user);
//
//            $address = new Address();
//            $address
//                ->setLatitude($faker->latitude)
//                ->setLongitude($faker->longitude);
//            $usersManager->persist($address);
//
//            $userAddress = new UsersAddress();
//            $userAddress
//                ->setUsers($user)
//                ->setAddress($address)
//                ->setLabel($faker->word)
//                ->setFacturation(true);
//
//            $usersManager->persist($userAddress);
//
//
//            $usersManager->flush();
//        }
//
////===========================================
////             Seller
//// 20 seller + address pour chaque
////===========================================
//        for ($i = 1; $i <= 20; $i++) {
//            $address = new Address();
//            $address
//                ->setLatitude($faker->latitude)
//                ->setLongitude($faker->longitude);
//            $usersManager->persist($address);
//
//            $seller = new Seller();
//            $seller
//                ->setNationalCode($faker->swiftBicNumber)
//                ->setCompanyName($faker->company)
//                ->setSellerName($faker->name)
//                ->setPhone("0649956639")
//                ->setEmail($faker->companyEmail)
//                ->setUsers($faker->randomElement($usersManager->getRepository(Users::class)->findAll()))
//                ->setAddress($address);
//
//            $usersManager->persist($seller);
//
//            $usersManager->flush();
//            $this->addReference('address ' . $i, $address);
//            $this->addReference('seller ' . $i, $seller);
//        }
//
////===========================================
////              ProductErp
//// creation de 20 categories dans l'ERP
////===========================================
//        for ($i = 1; $i <= 20; $i++) {
//            $categoryErp = new CategoryErp();
//            $categoryErp
//                ->setName($faker->word);
//
//            $erpManager->persist($categoryErp);
//        }
//        $erpManager->flush();
//
////===========================================
////              ProductSeller
//// 40 produits répartis aléatoirement parmi les seller existants, 3 pricings par produits et 3 images par produits + 1 a 3 categorieErp associés aleatoirement
////===========================================
//        for ($i = 1; $i <= 40; $i++) {
//            $productSeller = new ProductSeller();
//            $productSeller
//                ->setName($faker->word)
//                ->setDescription($faker->paragraph)
//                ->setSeasonalityStart($faker->dateTimeBetween('-2 months', '-1 month'))
//                ->setSeasonalityEnd($faker->dateTimeBetween('+1 month', '+2 months'))
//                ->setSeller($faker->randomElement($usersManager->getRepository(Seller::class)->findAll()));
//            $productsManager->persist($productSeller);
//
//            $associatedCategoryIds = [];
//
//            for ($j = 1; $j <= mt_rand(1, 3); $j++) {
//                $randomCategoryErp = $faker->randomElement($erpManager->getRepository(CategoryErp::class)->findAll());
//                while (in_array($randomCategoryErp->getId(), $associatedCategoryIds)) {
//                    $randomCategoryErp = $faker->randomElement($erpManager->getRepository(CategoryErp::class)->findAll());
//                }
//                $associatedCategoryIds[] = $randomCategoryErp->getId();
//
//
//                $categoryErpProductSeller = new CategoryErpProductSeller();
//                $categoryErpProductSeller
//                    ->setCategoryErp($randomCategoryErp)
//                    ->setProductSeller($productSeller);
//                $productsManager->persist($categoryErpProductSeller);
//            }
//
//            for ($j = 1; $j <= 3; $j++) {
//                $pricingSeller = new PricingSeller();
//                $pricingSeller
//                    ->setName($faker->word)
//                    ->setPrice($faker->randomFloat(2, 1, 1000))
//                    ->setTax(20)
//                    ->setStockLeft($faker->numberBetween(0, 100))
//                    ->setStockMin($faker->numberBetween(0, 10))
//                    ->setProductSeller($productSeller);
//                $productsManager->persist($pricingSeller);
//
//                $image = new Image();
//                $image
//                    ->setPath($faker->filePath())
//                    ->setName($faker->word)
//                    ->setAlternativText($faker->sentence);
//                $productsManager->persist($image);
//
//                $productSellerImage = new ProductSellerImage();
//                $productSellerImage
//                    ->setImages($image)
//                    ->setProducts($productSeller)
//                    ->setFront($faker->boolean);
//                $productsManager->persist($productSellerImage);
//            }
//            $productsManager->flush();
//        }
//
//
////===========================================
////              ProductErp
//// Creation de 40 productErp + 3 pricingErp pour chaque + 1 a 3 categorieErp par productErp
////===========================================
//        for ($i = 1; $i <= 20; $i++) {
//            $productErp = new ProductErp();
//            $productErp
//                ->setName($faker->sentence(2))
//                ->setDescription($faker->text)
//                ->setSeasonalityStart($faker->dateTimeBetween('now', '+1 month'))
//                ->setSeasonalityEnd($faker->dateTimeBetween('+1 month', '+6 months'));
//            for ($j = 1; $j <= mt_rand(1, 3); $j++) {
//                $productErp->addCategoryErp($faker->randomElement($erpManager->getRepository(CategoryErp::class)->findAll()));
//            }
//
//            $erpManager->persist($productErp);
//
//            for ($j = 1; $j <= 3; $j++) {
//                $pricingErp = new PricingErp();
//                $pricingErp
//                    ->setName($faker->word)
//                    ->setPrice($faker->randomFloat(2, 10, 200))
//                    ->setTax(20)
//                    ->setStockLeft($faker->numberBetween(0, 100))
//                    ->setStockMin($faker->numberBetween(10, 50))
//                    ->setProductErp($productErp);
//
//                $erpManager->persist($pricingErp);
//            }
//        }
//        $erpManager->flush();
//
////===========================================
////              REVIEWS
////===========================================
//
//        foreach ($usersManager->getRepository(Users::class)->findAll() as $user) {
//            for ($j = 1; $j <= mt_rand(1, 5); $j++) {
//                $review = new Review();
//                $review
//                    ->setComment($faker->realText())
//                    ->setNote($faker->randomFloat(null, 0, 5))
//                    ->setUser($user)
//                    ->setProduct(
//                        $faker->randomElement(
//                            array_merge(
//                                $productsManager->getRepository(ProductSeller::class)->findAll(),
//                                $erpManager->getRepository(ProductErp::class)->findAll()
//                            )
//                        )
//                    )
//                    ->setUpdatedAt($faker->dateTime);
//
//                $reviewsManager->persist($review);
//            }
//        }
//        $reviewsManager->flush();


//===========================================
//              PROMOTIONS
//===========================================

        for ($i = 1; $i <= 5; $i++) {
            $promotion = new Promotion();
            $promotion
                ->setName($faker->words(2, true))
                ->setPercentage(true)
                ->setDiscount($faker->randomFloat(2, 1, $max = 90))
                ->setStartFrom($faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now'))
                ->setEndAt($faker->dateTimeBetween($startDate = 'now', $endDate = '+1 month'))
                ->setPromoCode($faker->regexify('[A-Z0-9]{10}'));
            $promotionsManager->persist($promotion);


            $associatedProductsIds = [];
            $allProducts = array_merge(
                $productsManager->getRepository(ProductSeller::class)->findAll(),
                $erpManager->getRepository(ProductErp::class)->findAll()
            );

            for ($j = 1; $j <= mt_rand(2, 4); $j++) {
                $randomProduct = $faker->randomElement($allProducts);
                while (in_array($randomProduct->getId(), $associatedProductsIds)) {
                    $randomProduct = $faker->randomElement($allProducts);
                }
                $associatedProductsIds[] = $randomProduct->getId();

                $promotionProductSellerOrERP = new PromotionProductSellerOrErp();
                $promotionProductSellerOrERP
                    ->setPromotion($promotion)
                    ->setProduct($randomProduct);
                $promotionsManager->persist($promotionProductSellerOrERP);
            }

            $associatedCategoryIds = [];

            for ($j = 1; $j <= mt_rand(1, 2); $j++) {
                $randomCategoryErp = $faker->randomElement($erpManager->getRepository(CategoryErp::class)->findAll());
                while (in_array($randomCategoryErp->getId(), $associatedCategoryIds)) {
                    $randomCategoryErp = $faker->randomElement($erpManager->getRepository(CategoryErp::class)->findAll());
                }
                $associatedCategoryIds[] = $randomCategoryErp->getId();

                $promotionCategory = new PromotionCategory();
                $promotionCategory
                    ->setPromotion($promotion)
                    ->setCategoryErp($randomCategoryErp);
                $promotionsManager->persist($promotionCategory);
            }
        }

        $promotionsManager->flush();

////===========================================
////              DATABASE ORDERS
////===========================================
//
//    $order = new Orders();
//    $order
//    ->setUid($faker->uuid)
//    ->setStatus($faker->randomElement([0, 1, 2]))
        //->setPayedAt($faker->dateTimeBetween('-1 months', 'now'))
        //->setTotal($faker->randomFloat(2, 10, 1000))
        //->setCreatedAt($faker->dateTimeBetween('-2 months', '-1 months'))
        //->setUpdatedAt($faker->dateTime)
        //->setAddressUid($faker->uuid);
        //
        //$manager->persist($order);
        //
        //$userOrder = new UsersOrders();
        //$userOrder
        //->setUserUid($faker->uuid)
        //->setOrderUid($faker->uuid)
        //->setPaymentIntent($faker->word)
        //->setAmount($faker->randomFloat(2, 10, 1000))
        //->setCreatedAt($faker->dateTimeBetween('-2 months', '-1 months'))
        //->setUpdatedAt($faker->dateTime);
        //
        //$manager->persist($userOrder);
        //
        //$orderPricingSellerOrErp = new OrderPricingSellerOrErp();
        //$orderPricingSellerOrErp
        //->setProductSellerOrErpUid($faker->uuid)
        //->setOrderUid($faker->uuid)
        //->setQuantity($faker->numberBetween(1, 100));
        //
        //$manager->persist($orderPricingSellerOrErp);
        //
        //$manager->flush();
        //$this->addReference('order', $order);
        //$this->addReference('user order', $userOrder);
        //$this->addReference('order pricing seller or erp', $orderPricingSellerOrErp);


////===========================================
////              INVOICE
////===========================================


    }

}
