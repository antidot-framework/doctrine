<?php

declare(strict_types=1);


namespace AntidotTest\Persistence\Doctrine\Container;

use Antidot\Persistence\Doctrine\Container\Config\ConfigProvider;
use Antidot\Persistence\Doctrine\Container\DoctrineCliHelperSetFactory;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use RuntimeException;

class DoctrineCliHelperSetFactoryTest extends TestCase
{
    private const CUSTOM_CONNECTION_NAME = 'custom_conn';

    /** @var \PHPUnit\Framework\MockObject\MockObject|ContainerInterface */
    private $container;
    /** @var DoctrineCliHelperSetFactory */
    private DoctrineCliHelperSetFactory $factory;
    /** @var EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $entityManager;
    private string $servicename;
    private string $customServicename;

    public function setUp(): void
    {
        $this->servicename = sprintf(
            ConfigProvider::CONNECTION_ALIAS_PATTERN,
            ConfigProvider::DEFAULT_CONNECTION
        );
        $this->customServicename = sprintf(
            ConfigProvider::CONNECTION_ALIAS_PATTERN,
            self::CUSTOM_CONNECTION_NAME
        );
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->container = $this->createMock(ContainerInterface::class);
        $this->factory = new DoctrineCliHelperSetFactory();
    }

    public function testItShouldReturnAnInstanceOfDoctrineConsoleRunner(): void
    {
        $this->entityManager->expects($this->once())
            ->method('getConnection')
            ->willReturn($this->createMock(Connection::class));
        $this->container->expects($this->once())
            ->method('get')
            ->with($this->servicename)
            ->willReturn($this->entityManager);

        $this->factory->__invoke($this->container);
    }

    public function testItShouldReturnAnInstanceOfDoctrineConsoleRunnerWithDifferentConnections(): void
    {
        $this->entityManager->expects($this->once())
            ->method('getConnection')
            ->willReturn($this->createMock(Connection::class));
        $this->container->expects($this->once())
            ->method('get')
            ->with($this->customServicename)
            ->willReturn($this->entityManager);

        $this->factory->__invoke($this->container, self::CUSTOM_CONNECTION_NAME);
    }

    public function testItShouldThrowAnExceptionWhenEntityManagerIsNotPresentInTheDIContainer(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(sprintf(
            ConfigProvider::CONTAINER_EXCEPTION_MESSAGE_PATTER,
            EntityManagerInterface::class
        ));
        $this->factory->__invoke($this->container);
    }
}
