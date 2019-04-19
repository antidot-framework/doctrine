<?php

declare(strict_types=1);

namespace Antidot\Persistence\Doctrine\Container\Config;

use Antidot\Cli\Application\Console;
use Antidot\Persistence\Doctrine\Container\AntidotCliDoctrineDelegatorFactory;
use Antidot\Persistence\Doctrine\Container\DoctrineCliHelperSetFactory;
use ContainerInteropDoctrine\EntityManagerFactory;
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\DBAL\Tools\Console\Command\ImportCommand;
use Doctrine\DBAL\Tools\Console\Command\ReservedWordsCommand;
use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\Console\Command\ClearCache\CollectionRegionCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\EntityRegionCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryRegionCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand;
use Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand;
use Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand;
use Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand;
use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand;
use Doctrine\ORM\Tools\Console\Command\RunDqlCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;

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
                ],
            ],
            'console' => [
                'commands' => [
                    // DBAL Commands
                    'dbal:import' => ImportCommand::class,
                    'dbal:reserved-words' => ReservedWordsCommand::class,
                    'dbal:run-sql' => RunSqlCommand::class,

                    // ORM Commands
                    'orm:clear-cache:region:collection' => CollectionRegionCommand::class,
                    'orm:clear-cache:region:entity' => EntityRegionCommand::class,
                    'orm:clear-cache:metadata' => MetadataCommand::class,
                    'orm:clear-cache:query' => QueryCommand::class,
                    'orm:clear-cache:region:query' => QueryRegionCommand::class,
                    'orm:clear-cache:result' => ResultCommand::class,
                    'orm:schema-tool:create' => CreateCommand::class,
                    'orm:schema-tool:update' => UpdateCommand::class,
                    'orm:schema-tool:drop' => DropCommand::class,
                    'orm:ensure-production-settings' => EnsureProductionSettingsCommand::class,
                    'orm:convert-d1-schema' => ConvertDoctrine1SchemaCommand::class,
                    'orm:generate-repositories' => GenerateRepositoriesCommand::class,
                    'orm:generate-entities' => GenerateEntitiesCommand::class,
                    'orm:generate-proxies' => GenerateProxiesCommand::class,
                    'orm:convert-mapping' => ConvertMappingCommand::class,
                    'orm:run-dql' => RunDqlCommand::class,
                    'orm:validate-schema' => ValidateSchemaCommand::class,
                    'orm:info' => InfoCommand::class,
                    'orm:mapping:describe' => MappingDescribeCommand::class,
                ],
                'dependencies' => [
                    'invokables' => [
                        // DBAL Commands
                        ImportCommand::class => ImportCommand::class,
                        ReservedWordsCommand::class => ReservedWordsCommand::class,
                        RunSqlCommand::class => RunSqlCommand::class,

                        // ORM Commands
                        CollectionRegionCommand::class => CollectionRegionCommand::class,
                        EntityRegionCommand::class => EntityRegionCommand::class,
                        MetadataCommand::class => MetadataCommand::class,
                        QueryCommand::class => QueryCommand::class,
                        QueryRegionCommand::class => QueryRegionCommand::class,
                        ResultCommand::class => ResultCommand::class,
                        CreateCommand::class => CreateCommand::class,
                        UpdateCommand::class => UpdateCommand::class,
                        DropCommand::class => DropCommand::class,
                        EnsureProductionSettingsCommand::class => EnsureProductionSettingsCommand::class,
                        ConvertDoctrine1SchemaCommand::class => ConvertDoctrine1SchemaCommand::class,
                        GenerateRepositoriesCommand::class => GenerateRepositoriesCommand::class,
                        GenerateEntitiesCommand::class => GenerateEntitiesCommand::class,
                        GenerateProxiesCommand::class => GenerateProxiesCommand::class,
                        ConvertMappingCommand::class => ConvertMappingCommand::class,
                        RunDqlCommand::class => RunDqlCommand::class,
                        ValidateSchemaCommand::class => ValidateSchemaCommand::class,
                        InfoCommand::class => InfoCommand::class,
                        MappingDescribeCommand::class => MappingDescribeCommand::class,
                    ],
                    'delegators' => [
                        Console::class => [
                            AntidotCliDoctrineDelegatorFactory::class
                        ]
                    ],
                ],
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
