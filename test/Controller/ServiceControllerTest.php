<?php

namespace Test\Controller;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Test\DataFixture\ClientLoader;
use Test\DataFixture\BranchOfficeLoader;
use Test\DataFixture\ServiceLoader;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;


/**
 * Class UserControllerTest
 * @method Request getRequest()
 * @package Test\Controller
 */
class ServiceControllerTest extends AbstractConsoleControllerTestCase
{

    protected $traceError = true;

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
     *
     * Se popula las tablas con datos necesarios (Permisos, Roles, Usuarios y sus relaciones)
     */
    public function testCreateData()
    {
        $loader = new Loader();
        $loader->addFixture(new ClientLoader());
        $loader->addFixture(new BranchOfficeLoader());
        $loader->addFixture(new ServiceLoader());

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->getEm(), $purger);
        $executor->execute($loader->getFixtures());
        $this->assertResponseStatusCode(0);
    }


    /**
     * METHOD GET
     * ACTION get
     * DESC Obtener un registro especifico (administrator)
     */
    public function testGet()
    {
        $this->setUseConsoleRequest(false);
        $this->dispatch("/zfmc/api/services/1", "GET");


        $response = json_decode($this->getResponse()->getContent());

        $this->assertResponseStatusCode(200);

        $this->assertEquals($response->id, 1);
        $this->assertEquals($response->name, "General");

    }


    /**
     * METHOD GET
     * ACTION getlist
     * DESC Obtener un listado de registros
     */
    public function testGetList()
    {
        $this->setUseConsoleRequest(false);
        $this->dispatch("/zfmc/api/services", "GET");

        $response = json_decode($this->getResponse()->getContent());

        $this->assertResponseStatusCode(200);

        $this->assertEquals($response[0]->id, 1);
        $this->assertEquals($response[0]->name, "General");

    }


    /**
     * @depends testCreateData
     * METHOD POST
     * ACTION create
     * DESC crear un nuevo usuario
     */

    public function testCreate()
    {

        $this->setUseConsoleRequest(false);

        //Create Firt User

        $params = [
            "client" => 1,
            "branchOffice" => 1,
            "name" => "SERVICE TEST CREATE",

        ];

        $this->dispatch("/zfmr/api/services", "POST",
            $params);

        $jsonToCompare = [
            "status" => true,
            'id' => 4,
            "message" => "The item was created successfully"
        ];

        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($jsonToCompare));
        $this->assertResponseStatusCode(201);

    }


    /**
     * @depends testCreate
     * METHOD PUT
     * ACTION update
     * DESC actualizo un usuario
     */

    public function testUpdate()
    {

        $this->setUseConsoleRequest(false);

        $params = [
            "name" => "SERVICE TEST UPDATE",

        ];

        $this->dispatch("/zfmr/api/services/2", "PUT",
            $params);


        $jsonToCompare = [
            "status" => true,
            'id' => 2,
            "message" => "The item was updated successfully"
        ];

        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($jsonToCompare));
        $this->assertResponseStatusCode(200);
    }

    /**
     * @depends testUpdate
     * METHOD DELETE
     * ACTION delete
     * DESC elimino un usuario
     */

    public function testDelete()
    {

        $this->setUseConsoleRequest(false);


        $this->dispatch("/zfmr/api/services/3", "DELETE");


        $jsonToCompare = [
            "status" => true,
            "message" => "Item Delete"
        ];

        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($jsonToCompare));
        $this->assertResponseStatusCode(200);
    }


}
