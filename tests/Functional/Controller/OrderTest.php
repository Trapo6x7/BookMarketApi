<?php

// namespace App\Tests;

// use App\Entity\Order;
// use App\Entity\User;
// use App\Entity\Book;
// use App\Entity\OrderState;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

// class OrderTest extends KernelTestCase
// {
//     private ?EntityManagerInterface $entityManager;

//     protected function setUp(): void
//     {
//         $kernel = self::bootKernel();
//         $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
//     }

//     public function testOrderInsertion(): void
//     {
//         $buyer = new User();
//         $seller = new User();
//         $book = new Book();
//         $orderState = new OrderState();

//         $this->entityManager->persist($buyer);
//         $this->entityManager->persist($seller);
//         $this->entityManager->persist($book);
//         $this->entityManager->persist($orderState);
//         $this->entityManager->flush();

//         $order = new Order();
//         $order->setBuyer($buyer);
//         $order->setSeller($seller);
//         $order->setBook($book);
//         $order->setPurchaseAt(new \DateTimeImmutable());
//         $order->setOrderState($orderState);

//         $this->entityManager->persist($order);
//         $this->entityManager->flush();

//         $savedOrder = $this->entityManager->getRepository(Order::class)->find($order->getId());

//         $this->assertNotNull($savedOrder);
//         $this->assertSame($buyer, $savedOrder->getBuyer());
//         $this->assertSame($seller, $savedOrder->getSeller());
//         $this->assertSame($book, $savedOrder->getBook());
//         $this->assertSame($orderState, $savedOrder->getOrderState());
//     }

//     protected function tearDown(): void
//     {
//         parent::tearDown();
//         $this->entityManager->close();
//         $this->entityManager = null;
//     }
// }
