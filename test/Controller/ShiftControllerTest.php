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
use Zend\Crypt\Password\Bcrypt;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Parameters;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;
use ZfMetal\Restful\Transformation;

/**
 * Class UserControllerTest
 * @method Request getRequest()
 * @package Test\Controller
 */
class ShiftControllerTest extends AbstractConsoleControllerTestCase
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

        ini_set('display_errors', 'on');
        $this->configureServiceManager($this->getApplicationServiceLocator());
    }

    /**
     * Mockeo el EntityManager sobre el contenedor de servicios
     * @param ServiceManager $services
     */
    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);
        $services->setService(\ZfMetal\SecurityJwt\Service\JwtDoctrineIdentity::class, $this->getMockJwtDoctrineIdentity());
        $services->setAllowOverride(false);
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
      /*      $user = new \ZfMetal\Security\Entity\User();
            $user->setId(1);
            $user->setName("User Valid");
            $user->setUsername("userValid");
            $user->setEmail("user@gmail.com");
            $user->setPhone("1234");
            $user->setActive(true);
            $bcrypt = new Bcrypt(['cost' => 12]);
            $password = $bcrypt->create("validPassword");
            $user->setPassword($password);*/
            $this->user = $user;
        }
        return $this->user;
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

        $this->dispatch("/zfmc/shift/available-shifts/" . $calendarId . "/" . $date, "GET");


        echo $this->getResponse()->getContent();


        $responseToCompare = [
            [
                'calendar' => $calendarId,
                'date' => $date,
                'start' => $date . ' 09:00',
                'end' => $date . ' 10:00',
                'hour' => '09:00',
                'duration' => '60'
            ],
            [
                'calendar' => $calendarId,
                'date' => $date,
                'start' => $date . ' 10:00',
                'end' => $date . ' 11:00',
                'hour' => '10:00',
                'duration' => '60'
            ],
            [
                'calendar' => $calendarId,
                'date' => $date,
                'start' => $date . ' 11:00',
                'end' => $date . ' 12:00',
                'hour' => '11:00',
                'duration' => '60'
            ]
        ];

        $response = json_decode($this->getResponse()->getContent());

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testTakeAppointment()
    {
        $this->setUseConsoleRequest(false);


        $date = '2019-02-04';
        $hour = '11:00';
        $calendarId = 1;
        $duration = 60;
        $start = $date + " " + $hour;
        $end = $date + " " + '12:00';
        $token = "xxx";

        $params = [
            'calendar' => $calendarId,
            'start' => $start,
            'end' => $end,
            'duration' => $duration
        ];

      /*  $headers = new Headers();
        $headers->addHeaderLine('authorization', 'Bearer ' . $token);


        $this->getRequest()
            ->setHeaders($headers)
            ->setMethod('POST')
            ->setPost(new Parameters($params));*/


        $this->dispatch("/zfmc/shift/take-appointment/", "POST", $params);


        echo $this->getResponse()->getContent();





        $responseToCompare = [
            'status' => true,
            'item' => [
                'id' => 2,
                'user' => $this->getMockIdentity()->getId(),
                'calendar' => $calendarId,
                'start' => $start,
                'end' => $end,
                'duration' => 60
            ]

        ];

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


}
