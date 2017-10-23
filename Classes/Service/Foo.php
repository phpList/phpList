<?php
declare(strict_types=1);

namespace PhpList\PhpList4\Service;

use PhpList\PhpList4\Domain\Repository\Identity\AdministratorRepository;

/**
 * Container test class.
 */
class Foo
{
    /**
     * @var Bar
     */
    private $bar = null;

    /**
     * @var AdministratorRepository
     */
    private $administratorRepository = null;

    /**
     * @param Bar $bar
     * @param AdministratorRepository $administratorRepository
     */
    public function __construct(Bar $bar, AdministratorRepository $administratorRepository)
    {
        $this->bar = $bar;
        $this->administratorRepository = $administratorRepository;
    }

//    /**
//     * @param Bar $bar
//     *
//     * @return void
//     */
//    public function injectBar(Bar $bar)
//    {
//        $this->bar = $bar;
//    }

    /**
     * @return Bar
     */
    public function getBar(): Bar
    {
        return $this->bar;
    }

    /**
     * @return AdministratorRepository
     */
    public function getAdministratorRepository(): AdministratorRepository
    {
        return $this->administratorRepository;
    }
}
