<?php

declare(strict_types=1);

namespace Antidot\Persistence\Doctrine\Container;

use Antidot\Cli\Application\Console;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class AntidotCliDoctrineDelegatorFactory
{
    public function __invoke(ContainerInterface $container, string $name, callable $callback): Console
    {
        /** @var Console $console */
        $console = $callback();
        $definition = $console->getDefinition();
        $definition->addOption(new InputOption(
            'connection',
            'c',
            InputArgument::OPTIONAL,
            'Doctrine connection name.',
            'orm_default'
        ));
        $input = $console->getInput();
        try {
            $input->bind($definition);
        } catch (\Throwable $e) {
            // Errors must be ignored, full binding/validation happens later when the command is known.
        }

        /** @var string $connection */
        $connection = $input->getOption('connection') ?? 'orm_default';
        $console->setHelperSet((new DoctrineCliHelperSetFactory())->__invoke(
            $container,
            $connection
        ));

        $helperSet = $console->getHelperSet();
        $helperSet->set(new QuestionHelper(), 'question');
        $console->setHelperSet($helperSet);

        return $console;
    }
}
