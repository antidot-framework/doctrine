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
    public function __invoke(ContainerInterface $container, string $model): ObjectRepository
    {
        $em = $container->get(EntityManagerInterface::class);

        if (false === $em instanceof EntityManagerInterface) {
            throw new RuntimeException(sprintf(
                ConfigProvider::CONTAINER_EXCEPTION_MESSAGE_PATTER,
                EntityManagerInterface::class
            ));
        }

        return $em->getRepository($model);
    }
}
