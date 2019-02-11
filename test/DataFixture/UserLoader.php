<?php
/**
 * Created by PhpStorm.
 * User: crist
 * Date: 11/12/2018
 * Time: 00:14
 */

namespace Test\DataFixture;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\ORM\EntityManager;
use Zend\Crypt\Password\Bcrypt;
use ZfMetal\Security\Entity\User;


class UserLoader  extends AbstractFixture implements FixtureInterface
{

    const ENTITY = \ZfMetal\Security\Entity\User::class;



    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ArrayCollection
     */
    protected $users;

    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        if (!$this->users) {
            $this->users = new ArrayCollection();
        }
        return $this->users;
    }


    protected function findByName($name)
    {
        return $this->getEm()->getRepository($this::ENTITY)->findOneByName($name);
    }


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $this->em = $manager;

        $this->createUser(1, "User Valid", "UserValid","user@gmail.com","1234", "validPassword");

        $manager->flush();


    }


    /**
     * @param $id
     * @param $name
     * @param $tradename
     */
    public function createUser($id, $name,$username,$email,$phone,$password)
    {

        $user = $this->findByName($name);
        if (!$user) {
            $user = new User();
            $user->setId($id);
            $user->setName($name);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPhone($phone);
            $user->setActive(true);
            $bcrypt = new Bcrypt(['cost' => 12]);
            $password = $bcrypt->create($password);
            $user->setPassword($password);
        }


        $this->getEm()->persist($user);

        //Add reference for relations
        $this->addReference($username, $user);

        $this->getUsers()->add($user);
    }

}