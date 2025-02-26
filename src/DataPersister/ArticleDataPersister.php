<?php

namespace App\DataPersister;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Anounce;
use App\Entity\Article;
use App\Entity\Book;
use App\Entity\Order;
use App\Repository\ConditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class ArticleDataPersister implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Security $security,
        private readonly ConditionRepository $conditionRepository
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Article
    {
        if ($data instanceof Article && $operation instanceof Post) {

            $data->setAuthor($this->security->getUser());
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
