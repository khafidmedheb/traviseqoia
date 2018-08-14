<?php

namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
// use Liip\FunctionalTestBundle\Test\WebTestCase;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\User;



/**
 * Test de l'entité User de l'application 
 */
class UserRepositoryTest extends KernelTestCase
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	// private $entityManager;

	/**
	 * {@inheritDoc}
	 */
	protected function setUp()
	{
		$kernel = self::bootKernel();

		$this->entityManager = $kernel->getContainer()
		    ->get('doctrine')
		    ->getManager();
	}

	/**
	 * Test le renseignement d'un user dans la table Users
	 * Lien : http://symfony.com/doc/current/testing/doctrine.html
	 */
	public function testFindUserToto()
	{
		// Commande : ./vendor/bin/simple-phpunit --filter=testFindUserToto

		$resultExpected = "Toto";

		$users = $this->entityManager
		    ->getRepository(User::class)
		    ->getUserToto($resultExpected);

		$this->assertEquals($resultExpected, $users);
	}

    public function testFindAllUsers()
    {
    	// Commande : ./vendor/bin/simple-phpunit --filter=testFindAllUsers
    	
    	$resultExpected = 7;

    	$users = $this->entityManager
    	    ->getRepository(User::class)
    	    ->findAllUsers();

    	$this->assertCount($resultExpected, $users);
    }

	public function testListUsers()
    {
        // Commande : ./vendor/bin/simple-phpunit --filter=testListUsers

        $resultExpected = 7;

    	$users = $this->entityManager
    	    ->getRepository(User::class)
    	    ->findAllOrderedByName();

    	$this->assertCount($resultExpected, $users);

    }

  //   public function testLastUserIsTitus()
  //   {
  //   	// Commande : ./vendor/bin/simple-phpunit --filter=testLastUserIsTitus
    	
  //   	$resultExpected = "Titus";

		// $users = $this->entityManager
		//     ->getRepository(User::class)
		//     ->findLastUser($resultExpected);

		// $this->assertEquals($resultExpected, $users);
  //   }

    public function test_get_seven_users()
    {
        // Commande : ./vendor/bin/simple-phpunit --filter=test_get_six_users
       
        $users = $this->entityManager->getRepository(User::class)->findAll();

        $this->assertEquals(7, count($users));
    }

    // public function testAdminTotoIsPresent()
    // {
    //     // Commande : ./vendor/bin/simple-phpunit --filter=testAdminTotoIsPresent
       
    //     $users = $this->entityManager
    //         ->getRepository(User::class)
    //         ->verifyAdminTotoIsRegistered('Toto', 'toto@gmail.com');

    //         dump($users); die();

    //     $this->assertTrue($users, "Toto is here !");
    // }
    

  
	/**
	 * {@inheritDoc}
	 */
	protected function tearDown()
	{
		parent::tearDown();

		$this->entityManager->close();
		$this->entityManager = null;  //empêche les fuites mémoire

	}
	

}
