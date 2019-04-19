<?php

declare(strict_types=1);

namespace Antidot\Persistence\Doctrine\Container;

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Helper\HelperSet;

class DoctrineCliHelperSetFactory
{
    public function __invoke(ContainerInterface $container, string $connectionName): HelperSet
    {
        return ConsoleRunner::createHelperSet(
            $container->get('doctrine.entity_manager.' . $connectionName)
        );
    }
}
