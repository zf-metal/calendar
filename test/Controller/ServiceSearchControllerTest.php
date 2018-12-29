<?php

namespace Test\Controller;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Test\DataFixture\AccountLoader;
use Test\DataFixture\BranchOfficeLoader;
use Test\DataFixture\ServiceLoader;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;


/**
 * Class UserControllerTest
 * @method Request getRequest()
 * @package Test\Controller
 */
class ServiceSearchControllerTest extends AbstractConsoleControllerTestCase
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
     * METHOD GET
     * ACTION get
     * DESC Obtener un registro especifico (administrator)
     */
    public function testSearchById()
    {
        $this->setUseConsoleRequest(false);

        $params = [
            'id' => 1
        ];

        $this->dispatch("/zfmc/serviceSearch", "POST", $params);


        $response = json_decode($this->getResponse()->getContent());


        $responseToCompare = [
            [
                'id' => 1,
                'name' => "General",
                'account' => "MANOLO CHAPS",
                'branchOffice' => "Casa Central",
                'address' => 'Directorio'
            ]
        ];

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($responseToCompare));


        $this->assertEquals($response[0]->id, 1);
        $this->assertEquals($response[0]->name, "General");

    }


    /**
     * METHOD GET
     * ACTION get
     * DESC Obtener un registro especifico (administrator)
     */
    public function testSearchByAccountName()
    {
        $this->setUseConsoleRequest(false);

        $params = [
            'account' => "MANOLO CHAPS"
        ];

        $this->dispatch("/zfmc/serviceSearch", "POST", $params);


        $response = json_decode($this->getResponse()->getContent());


        $responseToCompare = [
            [
                'id' => 1,
                'name' => "General",
                'account' => "MANOLO CHAPS",
                'branchOffice' => "Casa Central",
                'address' => 'Directorio'
            ],
            [
                'id' => 2,
                'name' => "SERVICE TEST UPDATE",
                'account' => "MANOLO CHAPS",
                'branchOffice' => "Casa Central",
                'address' => 'Directorio'
            ],
            [
                'id' => 4,
                'name' => "SERVICE TEST CREATE",
                'account' => "MANOLO CHAPS",
                'branchOffice' => "Casa Central",
                'address' => 'Directorio'
            ]
        ];


        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($responseToCompare));


        $this->assertEquals($response[0]->id, 1);
        $this->assertEquals($response[0]->name, "General");

    }


    /**
     * METHOD GET
     * ACTION get
     * DESC Obtener un registro especifico (administrator)
     */
    public function testSearchByBranchOfficeName()
    {
        $this->setUseConsoleRequest(false);

        $params = [
            'branchOffice' => "Casa Central"
        ];

        $this->dispatch("/zfmc/serviceSearch", "POST", $params);


        $response = json_decode($this->getResponse()->getContent());


        $responseToCompare = [
            [
                'id' => 1,
                'name' => "General",
                'account' => "MANOLO CHAPS",
                'branchOffice' => "Casa Central",
                'address' => 'Directorio'
            ],
            [
                'id' => 4,
                'name' => "SERVICE TEST CREATE",
                'account' => "MANOLO CHAPS",
                'branchOffice' => "Casa Central",
                'address' => 'Directorio'
            ]
        ];

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($responseToCompare));


        $this->assertEquals($response[0]->id, 1);
        $this->assertEquals($response[0]->name, "General");

    }

    /**
     * METHOD GET
     * ACTION get
     * DESC Obtener un registro especifico (administrator)
     */
    public function testSearchByAddress()
    {
        $this->setUseConsoleRequest(false);

        $params = [
            'address' => "Directorio"
        ];

        $this->dispatch("/zfmc/serviceSearch", "POST", $params);


        $response = json_decode($this->getResponse()->getContent());


        $responseToCompare = [
            [
                'id' => 1,
                'name' => "General",
                'account' => "MANOLO CHAPS",
                'branchOffice' => "Casa Central",
                'address' => 'Directorio'
            ],
            [
                'id' => 4,
                'name' => "SERVICE TEST CREATE",
                'account' => "MANOLO CHAPS",
                'branchOffice' => "Casa Central",
                'address' => 'Directorio'
            ]
        ];

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($responseToCompare));


        $this->assertEquals($response[0]->id, 1);
        $this->assertEquals($response[0]->name, "General");

    }

    /**
     * METHOD GET
     * ACTION get
     * DESC Obtener un registro especifico (administrator)
     */
    public function testSearchByIdDoesNotExist()
    {
        $this->setUseConsoleRequest(false);

        $params = [
            'id' => 66
        ];

        $this->dispatch("/zfmc/serviceSearch", "POST", $params);


        $response = json_decode($this->getResponse()->getContent());


        $responseToCompare = [];

        echo $this->getResponse()->getContent();

        $this->assertResponseStatusCode(200);
        $this->assertJsonStringEqualsJsonString($this->getResponse()->getContent(), json_encode($responseToCompare));


    }

}
