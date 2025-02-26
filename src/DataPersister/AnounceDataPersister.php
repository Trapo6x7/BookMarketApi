<?php

namespace App\DataPersister;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Anounce;
use App\Entity\Book;
use App\Repository\ConditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class AnounceDataPersister implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Security $security,
        private readonly ConditionRepository $conditionRepository
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Anounce
    {
        if ($data instanceof Anounce && $operation instanceof Post) {

            $data->setSeller($this->security->getUser());
        }

        if ($data->getBook() === null) {
            $book = new Book();
            $book->setTitle($data->getBook()->getTitle()); // Ajuste selon besoin
            $this->entityManager->persist($book);
            $data->setBook($book);
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
