<?php
declare(strict_types=1);

namespace PhpList\PhpList4\Tests\Integration\Service;

use PhpList\PhpList4\Core\ApplicationKernel;
use PhpList\PhpList4\Core\Bootstrap;
use PhpList\PhpList4\Core\Environment;
use PhpList\PhpList4\Domain\Repository\Identity\AdministratorRepository;
use PhpList\PhpList4\EmptyStartPageBundle\Controller\DefaultController;
use PhpList\PhpList4\Service\Bar;
use PhpList\PhpList4\Service\Foo;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Testcase.
 *
 * @author Oliver Klee <oliver@phplist.com>
 */
class ServiceTest extends TestCase
{
    // So far:
    // OK: get public from container via key (other)
    // OK: get public from container via key (class name)
    // BROKEN: get public from container via class name (!= key)
    // OK: inject public via inject* method called via calls with key (other)
    // OK: inject public via inject* method called via calls with key (class name)
    // BROKEN: inject non-public via inject* method called via calls with key (class name)
    // OK: Autowiring constructor injection with type hint (that is not identical to the key) of public service
    // OK: Autowiring constructor injection with type hint (that is not identical to the key) of non-public service

    /**
     * @var ApplicationKernel
     */
    private $kernel = null;

    /**
     * @var ContainerInterface
     */
    private $container = null;

    protected function setUp()
    {
        $bootstrap = Bootstrap::getInstance();
        $bootstrap->setEnvironment(Environment::TESTING)->configure();

        $this->kernel = $bootstrap->getApplicationKernel();
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();
    }

    protected function tearDown()
    {
        $this->kernel->shutdown();
        Bootstrap::purgeInstance();
    }

    /**
     * @test
     */
    public function barIsAvailableViaContainerByClassName()
    {
        self::markTestSkipped('not now.');

        self::assertInstanceOf(Bar::class, $this->container->get('bar'));
    }

    /**
     * @test
     */
    public function fooIsAvailableViaContainerByAlias()
    {
        self::assertInstanceOf(Foo::class, $this->container->get('foo'));
    }

    /**
     * @test
     */
    public function barGetsInjectedViaInjectorCall()
    {
        /** @var Foo $foo */
        $foo = $this->container->get('foo');

        self::assertInstanceOf(Bar::class, $foo->getBar());
    }

    /**
     * @test
     */
    public function barGetsInjectedViaAutowiringWithInjectorCall()
    {
        /** @var Foo $foo */
        $foo = $this->container->get('foo');

        self::assertInstanceOf(Bar::class, $foo->getBar());
    }

    /**
     * @test
     */
    public function repositoryGetsInjectedViaAutowiringWithInjectorCall()
    {
        /** @var Foo $foo */
        $foo = $this->container->get('foo');

        self::assertInstanceOf(AdministratorRepository::class, $foo->getAdministratorRepository());
    }

    /**
     * @test
     */
    public function controllerCanBeFetchedAsService()
    {
        /** @var DefaultController $controller */
        $controller = $this->container->get(DefaultController::class);

        self::assertInstanceOf(DefaultController::class, $controller);
    }
}
