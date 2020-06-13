<?php

declare(strict_types=1);


namespace AntidotTest\Persistence\Doctrine\Container;

use Antidot\Cli\Application\Console;
use Antidot\Persistence\Doctrine\Container\AntidotCliDoctrineDelegatorFactory;
use Antidot\Persistence\Doctrine\Container\Config\ConfigProvider;
use Closure;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class AntidotCliDoctrineDelegatorFactoryTest extends TestCase
{
    /** @var AntidotCliDoctrineDelegatorFactory */
    private AntidotCliDoctrineDelegatorFactory $factory;
    /** @var \PHPUnit\Framework\MockObject\MockObject|ContainerInterface */
    private $container;
    /** @var Console|\PHPUnit\Framework\MockObject\MockObject */
    private $console;
    private Closure $callbackFunction;
    private string $servicename;
    /** @var EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $entityManager;

    public function setUp(): void
    {
        $this->servicename = sprintf(
            ConfigProvider::CONNECTION_ALIAS_PATTERN,
            ConfigProvider::DEFAULT_CONNECTION
        );
        $this->console = new Console();
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->container = $this->createMock(ContainerInterface::class);
        $this->factory = new AntidotCliDoctrineDelegatorFactory();
        $this->callbackFunction = fn() => $this->console;
    }

    public function testItShouldReturnADecoratedInstanceOfConsole(): void
    {
        $this->entityManager->expects($this->once())
            ->method('getConnection')
            ->willReturn($this->createMock(Connection::class));
        $this->container->expects($this->once())
            ->method('get')
            ->with($this->servicename)
            ->willReturn($this->entityManager);

        $this->factory->__invoke($this->container, '', $this->callbackFunction);
    }
}
