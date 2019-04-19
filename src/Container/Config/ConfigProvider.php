<?php

declare(strict_types=1);

namespace Antidot\Persistence\Doctrine\Container\Config;

use ContainerInteropDoctrine\EntityManagerFactory;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'factories' => [
                    'doctrine.entity_manager.orm_default' => EntityManagerFactory::class,
                ],
                'aliases' => [
                    EntityManagerInterface::class => 'doctrine.entity_manager.orm_default',
                ]
            ],
            'doctrine' => [
                'connection' => [
                    'orm_default' => [
                        'driver_class' => Driver::class,
                        'params' => [
                        ],
                    ],
                ],
                'driver' => [
                    'orm_default' => [
                        'class' => SimplifiedYamlDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            'config/doctrine/' => 'App\Domain\Model',
                        ],
                    ],
                ],
            ],
        ];
    }
}
