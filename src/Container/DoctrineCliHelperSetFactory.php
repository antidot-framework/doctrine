<?php

declare(strict_types=1);

namespace Antidot\Persistence\Doctrine\Container;

use Antidot\Persistence\Doctrine\Container\Config\ConfigProvider;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Psr\Container\ContainerInterface;
use RuntimeException;
use Symfony\Component\Console\Helper\HelperSet;

class DoctrineCliHelperSetFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $connectionName = ConfigProvider::DEFAULT_CONNECTION
    ): HelperSet {
        $entityManager = $container->get(sprintf(ConfigProvider::CONNECTION_ALIAS_PATTERN, $connectionName));

        if (false === $entityManager instanceof EntityManagerInterface) {
            throw new RuntimeException(sprintf(
                ConfigProvider::CONTAINER_EXCEPTION_MESSAGE_PATTERN,
                EntityManagerInterface::class
            ));
        }

        return ConsoleRunner::createHelperSet($entityManager);
    }
}
