<?php

namespace Test\Controller;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Test\DataFixture\CalendarLoader;
use Test\DataFixture\ScheduleLoader;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;
use ZfMetal\Restful\Transformation;

/**
 * Class UserControllerTest
 * @method Request getRequest()
 * @package Test\Controller
 */
class ShiftControllerTest extends AbstractConsoleControllerTestCase
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

        ini_set('display_errors', 'on');
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


        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->getEm(), $purger);
        $executor->execute($loader->getFixtures());
        $this->assertResponseStatusCode(0);
    }

    /**
     *
     */
    public function testAvailableShifts()
    {
        $this->setUseConsoleRequest(false);

        $date = '2019-02-04';

        $calendarId = 1;

        $params = [
            'calendarId' => $calendarId,
            'date' => $date
        ];

        $this->dispatch("/zfmc/available-shifts/".$calendarId."/".$date, "GET");


        echo $this->getResponse()->getContent();

        $response = json_decode($this->getResponse()->getContent());


        $responseToCompare = [
            [
                'calendarId' => 1,
                'shifts' => [
                    [
                        'calendar' => $calendarId,
                        'date' => $date,
                        'start' => $date.' 09:00',
                        'end' => $date.' 10:00',
                        'hour' => '09:00',
                        'duration' => '60'
                    ],
                    [
                        'calendar' => $calendarId,
                        'date' => $date,
                        'start' => $date.' 10:00',
                        'end' => $date.' 11:00',
                        'hour' => '10:00',
                        'duration' => '60'
                    ],
                    [
                        'calendar' => $calendarId,
                        'date' => $date,
                        'start' => $date.' 11:00',
                        'end' => $date.' 12:00',
                        'hour' => '11:00',
                        'duration' => '60'
                    ]
                ]
            ]
        ];

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($responseToCompare));
    }


}
