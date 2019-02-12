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


        $this->dispatch("/zfmc/shift/take-appointment/", "POST", $params);

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

        echo $this->getResponse()->getContent();

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString(json_encode($responseToCompare), $this->getResponse()->getContent());
    }


}
