<?php

namespace Test\Controller;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;

use \ZfMetal\Security\Entity\User;
use Test\DataFixture\CalendarLoader;
use Test\DataFixture\ScheduleLoader;
use Test\DataFixture\UserLoader;
use Zend\Http\Request;

use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;

/**
 * Class UserControllerTest
 * @method Request getRequest()
 * @package Test\Controller
 */
class DataLoaderControllerTest extends AbstractConsoleControllerTestCase
{

    protected $traceError = true;


    protected $mockJwtDoctrineIdentity;

    /**
     * @var \Zfmetal\Security\Entity\User
     */
    protected $user;

    /**
     * Inicializo el MVC
     */
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../config/application.config.php'
        );

        parent::setUp();

    }


    public function getEm()
    {
        return $this->getApplicationServiceLocator()->get(EntityManager::class);
    }

    /**
     * Se genera la estructura de la base de datos (Creacion de tablas)
     */
    public function testGenerateStructure()
    {

        $this->dispatch('orm:schema-tool:update --force');
        $this->assertResponseStatusCode(0);
    }

    /**
     * @depends testGenerateStructure
     * Se popula las tablas con datos necesarios (Permisos, Roles, Usuarios y sus relaciones)
     */
    public function testCreateData()
    {
        $loader = new Loader();
        $loader->addFixture(new CalendarLoader());
        $loader->addFixture(new ScheduleLoader());
        $loader->addFixture(new UserLoader());

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->getEm(), $purger);
        $executor->execute($loader->getFixtures());
        $this->assertResponseStatusCode(0);
    }



}
