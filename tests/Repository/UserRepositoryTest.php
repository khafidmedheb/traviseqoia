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
	private $entityManager;

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
	 * Recherche si user10 existe dans users
	 *
	 */
	public function testFindUserTen()
	{
		// Commande : ./vendor/bin/simple-phpunit --filter=testFindUserToto

		$resultExpected = "user10";

		$users = $this->entityManager
		    ->getRepository(User::class)
		    ->getUserToto($resultExpected);

		$this->assertEquals($resultExpected, $users);
	}

    /**
     * Recherche si le nomnre de users correspond à un nombre attendu
     * A utiliser avec les loadfixtures
     */
    public function testFindAllUsers()
    {
    	// Commande : ./vendor/bin/simple-phpunit --filter=testFindAllUsers
    	
    	$resultExpected = 20;

    	$users = $this->entityManager
    	    ->getRepository(User::class)
    	    ->findAllUsers();

    	$this->assertCount($resultExpected, $users);
    }
    
    /**
     * Recherche si le nomnre de users correspond à un nombre attendu
     * A utiliser avec les loadfixtures
     */
	public function testListUsers()
    {
        // Commande : ./vendor/bin/simple-phpunit --filter=testListUsers

        $resultExpected = 9;

    	$users = $this->entityManager
    	    ->getRepository(User::class)
    	    ->findAllOrderedByName();

    	$this->assertCount($resultExpected, $users);

    }

    public function testLastUserIsTitus()
    {
    	// Commande : ./vendor/bin/simple-phpunit --filter=testLastUserIsTitus
    	
    	$resultExpected = "Titus";

		$users = $this->entityManager
		    ->getRepository(User::class)
		    ->findLastUser($resultExpected);

		$this->assertEquals($resultExpected, $users);
    }

    public function testAdminTestNomIsPresent()
    {
        // Commande : ./vendor/bin/simple-phpunit --filter=testAdminTotoIsPresent
       
        $users = $this->entityManager
            ->getRepository(User::class)
            ->verifyAdminTotoIsRegistered("Test nom", "test@gmail.com");

        $this->assertCount(1, $users);
    }
    
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
