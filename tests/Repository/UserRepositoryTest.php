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
	// protected function setUp()
	// {
	// 	$kernel = self::bootKernel();

	// 	$this->entityManager = $kernel->getContainer()
	// 	    ->get('doctrine')
	// 	    ->getManager();
	// }

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

		// $this->assertCount(1, $users );
	}

	public function testListUsers()
    {
        // Commande : php 

        // self::bootKernel();

        // // returns the real and unchanged service container
        // $container = self::$kernel->getContainer();

        // // gets the special container that allows fetching private services
        // $container = self::$container;

        // $user = self::$container->get('doctrine')->getRepository(User::class)->findAllOrderedByName();

        // $this->assertTrue(self::$container->get('security.password_encoder')->isPasswordValid($user, '...'));

        //On doit trouver n users dans notre table
        // $this->assertCount(5, $users );


        // $users = $this->entityManager
        //     ->getRepository(User::class)
        //     ->findAllOrderedByName();

        //On doit trouver n users dans notre table
        // $this->assertCount(2, $users );
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
