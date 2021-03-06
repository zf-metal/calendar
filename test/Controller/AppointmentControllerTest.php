<?php

namespace Test\Controller;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use ZfMetal\Calendar\Controller\AppointmentApiController;
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
class AppointmentControllerTest extends AbstractHttpControllerTestCase
{

    protected $traceError = true;


    protected $mockJwtDoctrineIdentity;

    /**
     * @var \Zfmetal\Security\Entity\User
     */
    protected $user;



    protected $mockJwtDoctrineIdentity2;

    /**
     * @var \Zfmetal\Security\Entity\User
     */
    protected $user2;

    /**
     * Inicializo el MVC
     */
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../config/application.config.php'
        );


        parent::setUp();

        $this->configureServiceManager();

    }

    /**
     * Mockeo el EntityManager sobre el contenedor de servicios
     * @param ServiceManager $services
     */
    protected function configureServiceManager()
    {
        $this->getApplicationServiceLocator()->setAllowOverride(true);
        $this->getApplicationServiceLocator()->setService(\ZfMetal\SecurityJwt\Service\JwtDoctrineIdentity::class, $this->getMockJwtDoctrineIdentity());
        //  $services->setAllowOverride(false);
    }

    public function getMockJwtDoctrineIdentity()
    {

        if (!$this->mockJwtDoctrineIdentity) {

            $this->mockJwtDoctrineIdentity = $this->createMock(\ZfMetal\SecurityJwt\Service\JwtDoctrineIdentity::class);
            $this->mockJwtDoctrineIdentity->method('getIdentity')
                ->willReturn($this->getMockIdentity());
        }
        return $this->mockJwtDoctrineIdentity;
    }

    public function getMockIdentity()
    {

        if (!$this->user) {
            $user = $this->getEm()->getRepository(User::class)->find(1);
            $this->user = $user;
        }
        return $this->user;
    }

    public function getMockJwtDoctrineIdentity2()
    {

        if (!$this->mockJwtDoctrineIdentity2) {

            $this->mockJwtDoctrineIdentity2 = $this->createMock(\ZfMetal\SecurityJwt\Service\JwtDoctrineIdentity::class);
            $this->mockJwtDoctrineIdentity2->method('getIdentity')
                ->willReturn($this->getMockIdentity2());
        }
        return $this->mockJwtDoctrineIdentity2;
    }

    public function getMockIdentity2()
    {

        if (!$this->user2) {
            $user2 = $this->getEm()->getRepository(User::class)->find(2);
            $this->user2 = $user2;
        }
        return $this->user2;

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
     * Se popula las tablas con datos necesarios
     */
    public function testCreateData()
    {
        $this->setUseConsoleRequest(false);
        $loader = new Loader();
        $loader->addFixture(new UserLoader());
        $loader->addFixture(new CalendarLoader());
        $loader->addFixture(new ScheduleLoader());


        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->getEm(), $purger);
        $executor->execute($loader->getFixtures());
        //$this->assertResponseStatusCode(200);
    }


    /**
     * @depends testCreateData
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testTakeAppointment()
    {
        $this->setUseConsoleRequest(false);


        $date = '2020-02-04';
        $hour = '12:00';
        $calendarId = 1;
        $calendarName = "CalendarTest";
        $duration = 60;
        $start = $date . " " . $hour;
        $end = $date . " " . '13:00';
        $token = "xxx";

        $params = [
            'calendar' => $calendarId,
            'start' => $start,
            'duration' => $duration
        ];


        $this->dispatch("/zfmc/api/appointments/take", "POST", $params);

        $responseToCompare = [
            'status' => true,
            'message' => "Su turno ha sido confirmado satisfactoriamente.",
            'item' => [
                'id' => 1,
                'user' => ["id" => $this->getMockIdentity()->getId(), "name" => $this->getMockIdentity()->getName()],
                'calendar' => ["id" => $calendarId, "name" => $calendarName],
                'start' => $start,
                'end' => $end,
                'duration' => 60,
                'status' => 1,
                'statusName' => 'Activo'
            ]
        ];


        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }

    /**
     * @depends testTakeAppointment
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testTakeSecondAppointment()
    {
        $this->setUseConsoleRequest(false);


        $date = '2018-02-04';
        $hour = '12:00';
        $calendarId = 2;
        $calendarName = "CalendarTestSegundo";
        $duration = 60;
        $start = $date . " " . $hour;
        $end = $date . " " . '13:00';
        $token = "xxx";

        $params = [
            'calendar' => $calendarId,
            'start' => $start,
            'duration' => $duration
        ];


        $this->dispatch("/zfmc/api/appointments/take", "POST", $params);

        $responseToCompare = [
            'status' => true,
            'message' => "Su turno ha sido confirmado satisfactoriamente.",
            'item' => [
                'id' => 2,
                'user' => ["id" => $this->getMockIdentity()->getId(), "name" => $this->getMockIdentity()->getName()],
                'calendar' => ["id" => $calendarId, "name" => $calendarName],
                'start' => $start,
                'end' => $end,
                'duration' => 60,
                'status' => 1,
                'statusName' => 'Activo'
            ]
        ];


        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


    /**
     * @depends testTakeAppointment
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testTakeAppointmentRejectedForPreviusAppointment()
    {
        $this->setUseConsoleRequest(false);


        $date = '2020-02-04';
        $hour = '18:00';
        $calendarId = 1;
        $calendarName = "CalendarTest";
        $duration = 60;
        $start = $date . " " . $hour;
        $end = $date . " " . '13:00';
        $token = "xxx";

        $params = [
            'calendar' => $calendarId,
            'start' => $start,
            'duration' => $duration
        ];


        $this->dispatch("/zfmc/api/appointments/take", "POST", $params);

        $responseToCompare = [
            'status' => false,
            'message' => "Ya cuenta con un turno pendiente para esta agenda. No es posible acumular turnos."
        ];


        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }

    /**
     * @depends testTakeAppointment
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testTakeAppointmentRejectedForAvailability()
    {
        $this->setUseConsoleRequest(false);

        $this->getApplicationServiceLocator()->setService(\ZfMetal\SecurityJwt\Service\JwtDoctrineIdentity::class, $this->getMockJwtDoctrineIdentity2());


        $date = '2020-02-04';
        $hour = '12:00';
        $calendarId = 1;
        $duration = 60;
        $start = $date . " " . $hour;
        $end = $date . " " . '13:00';
        $token = "xxx";

        $params = [
            'calendar' => $calendarId,
            'start' => $start,
            'duration' => $duration
        ];


        $this->dispatch("/zfmc/api/appointments/take", "POST", $params);

        $responseToCompare = [
            'status' => false,
            'message' => "Lo sentimos. El turno solicitado ya no esta disponible."
        ];

        echo $this->getResponse()->getContent();

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


    /**
     * @depends  testTakeSecondAppointment
     */
    public function testMyAppointments()
    {
        $this->setUseConsoleRequest(false);


        $this->dispatch("/zfmc/api/appointments/my-appointments", "GET");


        $responseToCompare = [
            [
                'id' => 1,
                'user' => ["id" => $this->getMockIdentity()->getId(), "name" => $this->getMockIdentity()->getName()],
                'calendar' => ["id" => 1, "name" => "CalendarTest"],
                'start' => '2020-02-04 12:00',
                'end' => '2020-02-04 13:00',
                'duration' => 60,
                'status' => 1,
                'statusName' => 'Activo'
            ],
            /*            [
                            'id' => 2,
                            'user' => $this->getMockIdentity()->getId(),
                            'calendar' => ["id" => 1, "name" => "CalendarTest"],
                            'start' => '2018-02-04 12:00',
                            'end' => '2018-02-04 13:00',
                            'duration' => 60
                        ]*/
        ];

        $response = json_decode($this->getResponse()->getContent());

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


    /**
     * @depends  testTakeAppointment
     */
    public function testAvailable()
    {
        $this->setUseConsoleRequest(false);

        $date = '2020-02-04';

        $calendarId = 1;

        $params = [
            'calendarId' => $calendarId,
            'date' => $date
        ];

        $this->dispatch("/zfmc/api/appointments/availables/" . $calendarId . "/" . $date, "GET");


        $responseToCompare = [
            [
                'calendar' => $calendarId,
                'date' => $date,
                'start' => $date . ' 09:00',
                'end' => $date . ' 10:00',
                'hour' => '09:00',
                'duration' => '60',
                'day' => 2
            ],
            [
                'calendar' => $calendarId,
                'date' => $date,
                'start' => $date . ' 10:00',
                'end' => $date . ' 11:00',
                'hour' => '10:00',
                'duration' => '60',
                'day' => 2
            ],
            [
                'calendar' => $calendarId,
                'date' => $date,
                'start' => $date . ' 11:00',
                'end' => $date . ' 12:00',
                'hour' => '11:00',
                'duration' => '60',
                'day' => 2
            ]
        ];

        $response = json_decode($this->getResponse()->getContent());

        //var_dump($response);

        $this->assertControllerName(AppointmentApiController::class);
        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


    /**
     * @depends testTakeSecondAppointment
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testCancel()
    {
        $this->setUseConsoleRequest(false);


        $id = 1;
        $date = '2020-02-04';
        $hour = '12:00';
        $calendarId = 1;
        $calendarName = "CalendarTest";
        $duration = 60;
        $start = $date . " " . $hour;
        $end = $date . " " . '13:00';
        $token = "xxx";

        $params = [
            'id' => $id
        ];


        $this->dispatch("/zfmc/api/appointments/cancel/" . $id, "POST", $params);

        $responseToCompare = [
            'status' => true,
            'message' => "El turno ha sido cancelado",
            'item' => [
                'id' => 1,
                'user' => ["id" => $this->getMockIdentity()->getId(), "name" => $this->getMockIdentity()->getName()],
                'calendar' => ["id" => $calendarId, "name" => $calendarName],
                'start' => $start,
                'end' => $end,
                'duration' => 60,
                'status' => 2,
                'statusName' => 'Cancelado'
            ]

        ];

        echo $this->getResponse()->getContent();

        $this->assertControllerName(AppointmentApiController::class);
        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


    /**
     * @depends testTakeSecondAppointment
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testCancelLapsed()
    {
        $this->setUseConsoleRequest(false);


        $id = 2;


        $params = [
            'id' => $id
        ];


        $this->dispatch("/zfmc/api/appointments/cancel/" . $id, "POST", $params);

        $responseToCompare = [
            'status' => false,
            'message' => "El turno ha caducado"
        ];

        echo $this->getResponse()->getContent();

        $this->assertControllerName(AppointmentApiController::class);
        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


    /**
     * @depends  testCancel
     */
    public function testTheAppointments()
    {
        $this->setUseConsoleRequest(false);


        $this->dispatch("/zfmc/api/appointments?start=>=2018-02-04", "GET");


        $responseToCompare = [
            [
                'id' => 1,
                'user' => ["id" => $this->getMockIdentity()->getId(), "name" => $this->getMockIdentity()->getName()],
                'calendar' => ["id" => 1, "name" => "CalendarTest"],
                'start' => '2020-02-04 12:00',
                'end' => '2020-02-04 13:00',
                'duration' => 60,
                'status' => 2,
                'statusName' => 'Cancelado'
            ],
            [
                'id' => 2,
                'user' => ["id" => $this->getMockIdentity()->getId(), "name" => $this->getMockIdentity()->getName()],
                'calendar' => ["id" => 2, "name" => "CalendarTestSegundo"],
                'start' => '2018-02-04 12:00',
                'end' => '2018-02-04 13:00',
                'duration' => 60,
                'status' => 1,
                'statusName' => 'Activo'
            ]
        ];

        $response = json_decode($this->getResponse()->getContent());

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


}
