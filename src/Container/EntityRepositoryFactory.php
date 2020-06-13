<?php

declare(strict_types=1);

namespace Antidot\Persistence\Doctrine\Container;

use Antidot\Persistence\Doctrine\Container\Config\ConfigProvider;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Psr\Container\ContainerInterface;
use RuntimeException;

class EntityRepositoryFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $model,
        string $connectionName = ConfigProvider::DEFAULT_CONNECTION
    ): ObjectRepository {
        $entityManager = $container->get(sprintf(ConfigProvider::CONNECTION_ALIAS_PATTERN, $connectionName));

        if (false === $entityManager instanceof EntityManagerInterface) {
            throw new RuntimeException(sprintf(
                ConfigProvider::CONTAINER_EXCEPTION_MESSAGE_PATTERN,
                EntityManagerInterface::class
            ));
        }

        return $entityManager->getRepository($model);
    }
}
