<?php

declare(strict_types=1);

namespace Antidot\Persistence\Doctrine\Container;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class EntityRepositoryFactory
{
    public function __invoke(ContainerInterface $container, string $model)
    {
        $em = $container->get(EntityManagerInterface::class);

        return $em->getRepository($model);
    }
}
