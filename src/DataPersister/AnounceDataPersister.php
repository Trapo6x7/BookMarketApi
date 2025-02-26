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
            // // Décoder le contenu de la requête
            // $requestData = json_decode($context['request']->getContent(), true);

            // // Récupérer l'ID du state depuis le JSON décodé
            // $stateId = $requestData['state'] ?? null;

            // if (!$stateId) {
            //     throw new \RuntimeException('State ID is required');
            // }
            
            // // Récupérer l'entité State correspondante
            // $state = $this->conditionRepository->find($stateId);
            
            // if (!$state) {
            //     throw new \RuntimeException('State not found');
            // }
            
            // // Associer le state à l'annonce
            // $data->setState($state);

            // Définir le vendeur
            $data->setSeller($this->security->getUser());
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
