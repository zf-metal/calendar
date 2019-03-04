<?php

namespace Test\Controller;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Test\DataFixture\CalendarLoader;
use Test\DataFixture\ClientLoader;
use Test\DataFixture\BranchOfficeLoader;
use Test\DataFixture\ServiceLoader;
use Test\DataFixture\UserLoader;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;
use ZfMetal\Calendar\Controller\CalendarApiController;


/**
 * Class UserControllerTest
 * @method Request getRequest()
 * @package Test\Controller
 */
class CalendarRestfulControllerTest extends AbstractConsoleControllerTestCase
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
        $loader->addFixture(new UserLoader());
        $loader->addFixture(new CalendarLoader());


        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->getEm(), $purger);
        $executor->execute($loader->getFixtures());
        $this->assertResponseStatusCode(0);
    }


    /**
     * @depends testCreateData
     * METHOD GET
     * ACTION get
     * DESC Obtener un registro especifico (calendar)
     */
    public function testGet()
    {
        $this->setUseConsoleRequest(false);
        $this->dispatch("/zfmc/api/calendars/1", "GET");


        $response = json_decode($this->getResponse()->getContent());


        $this->assertResponseStatusCode(200);

        $this->assertEquals($response->id, 1);
        $this->assertEquals($response->name, "CalendarTest");

    }


    /**
     * @depends testCreateData
     * METHOD GET
     * ACTION getlist
     * DESC Obtener un listado de registros
     */
    public function testGetList()
    {
        $this->setUseConsoleRequest(false);
        $this->dispatch("/zfmc/api/calendars", "GET");

        $response = json_decode($this->getResponse()->getContent());


        $this->assertResponseStatusCode(200);

        $this->assertEquals($response[0]->id, 1);
        $this->assertEquals($response[0]->name, "CalendarTest");

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
            "name" => "Calendar Created",
            "description" => "Descripcion del Calendario",
            "user" => 1,
            "schedules" => [
                ["day" => 1, "start" => "09:00", "end" => "12:00"],
                ["day" => 2, "start" => "09:00", "end" => "12:00"]
            ]
        ];

        $this->dispatch("/zfmc/api/calendars", "POST",
            $params);

        $jsonToCompare = [
            "status" => true,
            'id' => 3,
            "message" => "The item was created successfully"
        ];

        $this->assertControllerName(CalendarApiController::class);
        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($jsonToCompare));
        $this->assertResponseStatusCode(201);

    }


    /**
     * @depends testCreate
     * METHOD POST
     * ACTION create
     * DESC crear un nuevo usuario
     */

    public function testCreateTwo()
    {

        $this->setUseConsoleRequest(false);

        //Create Firt User

        $params = [
            "name" => "Calendar Created Two",
            "description" => "Two Calendar Created",
            "user" => 1,
            "schedules" => [
                ["day" => 1, "start" => "08:00", "end" => "13:00"],
                ["day" => 2, "start" => "08:00", "end" => "13:00"],
                ["day" => 3, "start" => "08:00", "end" => "13:00"]
            ]
        ];

        $this->dispatch("/zfmc/api/calendars", "POST",
            $params);

        $jsonToCompare = [
            "status" => true,
            'id' => 4,
            "message" => "The item was created successfully"
        ];

        $this->assertControllerName(CalendarApiController::class);
        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($jsonToCompare));
        $this->assertResponseStatusCode(201);

    }

    /**
     * @depends testCreateTwo
     * METHOD PUT
     * ACTION update
     * DESC actualizo un usuario
     */

    public function testUpdate()
    {

        $this->setUseConsoleRequest(false);

        $params = [
            "name" => "Calendar Update",
            "description" => "Descripcion del Calendario Actualizado",
            "user" => 1,
            "schedules" => [
                ["id" => 4,"day" => 2, "start" => "07:00", "end" => "14:00"],
                ["id" => 5,"day" => 3, "start" => "07:00", "end" => "14:00"]
            ]
        ];

        $this->dispatch("/zfmc/api/calendars/4", "PUT",
            $params);


        $jsonToCompare = [
            "status" => true,
            'id' => 4,
            "message" => "The item was updated successfully"
        ];
        $this->assertControllerName(CalendarApiController::class);
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


        $this->dispatch("/zfmr/api/clients/2", "DELETE");


        $jsonToCompare = [
            "message" => "Item Delete"
        ];

        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($jsonToCompare));
        $this->assertResponseStatusCode(200);
    }


}
