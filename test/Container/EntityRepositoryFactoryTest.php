<?php

declare(strict_types=1);


namespace AntidotTest\Persistence\Doctrine\Container;

use Antidot\Persistence\Doctrine\Container\Config\ConfigProvider;
use Antidot\Persistence\Doctrine\Container\EntityRepositoryFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use RuntimeException;

class EntityRepositoryFactoryTest extends TestCase
{
    private const ENTITY_CLASS = 'Some\Entity';
    /** @var EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $entityManager;
    /** @var \PHPUnit\Framework\MockObject\MockObject|ContainerInterface */
    private $container;
    /** @var EntityRepositoryFactory */
    private EntityRepositoryFactory $factory;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->container = $this->createMock(ContainerInterface::class);
        $this->factory = new EntityRepositoryFactory();
    }

    public function testItShouldThrowAnExceptionWhenEntityManagerIsNotPresentInTheDIContainer(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(sprintf(
            ConfigProvider::CONTAINER_EXCEPTION_MESSAGE_PATTER,
            EntityManagerInterface::class
        ));
        $this->factory->__invoke($this->container, self::ENTITY_CLASS);
    }

    public function testItShouldCreatANewInstancesOfObjectRepository(): void
    {
        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(self::ENTITY_CLASS)
            ->willReturn($this->createMock(ObjectRepository::class));
        $this->container->expects($this->once())
            ->method('get')
            ->with(EntityManagerInterface::class)
            ->willReturn($this->entityManager);

        $this->factory->__invoke($this->container, self::ENTITY_CLASS);
    }
}
