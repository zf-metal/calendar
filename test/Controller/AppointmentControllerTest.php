<?php

namespace Test\Controller;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
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


    public function getEm()
    {
        return $this->getApplicationServiceLocator()->get(EntityManager::class);
    }


    /**
     * Se popula las tablas con datos necesarios
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
        $this->assertResponseStatusCode(200);
    }


    /**
     * @depends testCreateData
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testTakeAppointment()
    {
        $this->setUseConsoleRequest(false);


        $date = '2020-02-04';
        $hour = '11:00';
        $calendarId = 1;
        $calendarName = "CalendarTest";
        $duration = 60;
        $start = $date . " " . $hour;
        $end = $date . " " . '12:00';
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
                'user' => $this->getMockIdentity()->getId(),
                'calendar' => ["id" => $calendarId, "name" => $calendarName],
                'start' => $start,
                'end' => $end,
                'duration' => 60
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
                'id' => 2,
                'user' => $this->getMockIdentity()->getId(),
                'calendar' => ["id" => $calendarId, "name" => $calendarName],
                'start' => $start,
                'end' => $end,
                'duration' => 60
            ]
        ];


        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


    /**
     * @depends testTakeSecondAppointment
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testTakeAppointmentRejected()
    {
        $this->setUseConsoleRequest(false);


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
                'user' => $this->getMockIdentity()->getId(),
                'calendar' => ["id" => 1, "name" => "CalendarTest"],
                'start' => '2020-02-04 11:00',
                'end' => '2020-02-04 12:00',
                'duration' => 60
            ],
            [
                'id' => 2,
                'user' => $this->getMockIdentity()->getId(),
                'calendar' => ["id" => 1, "name" => "CalendarTest"],
                'start' => '2020-02-04 12:00',
                'end' => '2020-02-04 13:00',
                'duration' => 60
            ]
        ];

        $response = json_decode($this->getResponse()->getContent());

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }

    /**
     * @depends  testCreateData
     */
    public function testAvailableShifts()
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


        $id = 2;


        $params = [
            'id' => $id
        ];


        $this->dispatch("/zfmc/api/appointments/cancel", "PUT", $params);

        $responseToCompare = [
            'status' => false,
            'message' => "El turno solicitado no esta disponible"
        ];

        echo $this->getResponse()->getContent();

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


}
