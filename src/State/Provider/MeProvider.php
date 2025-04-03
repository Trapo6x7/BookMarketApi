<?php

namespace App\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class MeProvider implements ProviderInterface
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger // Ajout de l'EntityManager
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $this->logger->debug('MeProvider called', [
            'operation' => $operation->getName(),
            'authenticated' => $this->security->isGranted('IS_AUTHENTICATED_FULLY'),
            'hasToken' => $this->security->getToken() !== null
        ]);

        try {
            $user = $this->security->getUser();
            
            if (!$user) {
                $this->logger->error('No user found in security context');
                throw new UnauthorizedHttpException('Bearer', 'User not authenticated');
            }

            /** @var User $user */
            $this->logger->debug('User found', [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles()
            ]);

            return $user;
            
        } catch (\Exception $e) {
            $this->logger->error('Error in MeProvider', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
