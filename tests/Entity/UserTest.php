<?php

namespace Tests\Entity;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
// use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
// use Liip\FunctionalTestBundle\Test\WebTestCase;
// use Doctrine\Bundle\FixturesBundle\Fixture;
// use Doctrine\Common\Persistence\ObjectManager;

use App\Tests\DataFixtures\AppFixturesTest;
use App\Entity\User;


/**
 * Test de l'entité User de l'application 
 */
class UserTest extends AppFixturesTest
{
	protected $userService;

	/**
	 * {@inheritDoc}
	 */
	// public function setUp()
	// {
	// 	parent::setup();
	// 	$this->userService = $this->container->get('app.service.user');
	// }

	public function test_get_five_users()
	{
		// Commande : ./vendor/bin/simple-phpunit --filter=test_get_five_users

		$users = $this->entityManager->getRepository(User::class)->findAll();
		
		$this->assertEquals(5, count($users));
	}

	public function testFindAllUsers()
    {
        // Commande : ./vendor/bin/simple-phpunit --filter=testFindAllUsers

        // self::bootKernel();

        // // returns the real and unchanged service container
        // $container = self::$kernel->getContainer();

        // // gets the special container that allows fetching private services
        // $container = self::$container;

        // $user = self::$container->get('doctrine')->getRepository(User::class)->findOneByEmail('...');
        // $this->assertTrue(self::$container->get('security.password_encoder')->isPasswordValid($user, '...'));
        // ...
        // ...
        // dump('TESTTTTTTTTTTTTTTTTTTTTTTTTT'); die();
        self::bootKernel();

        // returns the real and unchanged service container
        $container = self::$kernel->getContainer();

        // gets the special container that allows fetching private services
        $container = self::$container;

        $users = self::$container->get('doctrine')->getRepository(User::class)->findAllOrderedByName();

        // dump($users); die();

        // $this->assertTrue(self::$container->get('security.password_encoder')->isPasswordValid($user, '...'));

        //On doit trouver n users dans notre table
        // $this->assertCount(5, $users);

    }

	/**
	 * Test le renseignement d'un user dans la table Users
	 * Lien : http://symfony.com/doc/current/testing/doctrine.html
	 */
	// public function testQuery()
	// {
	// 	// Commande : ./vendor/bin/simple-phpunit --filter=testQuery

	// 	$resultExpected = "Titus";

	// 	$kernel = static::createKernel();
	// 	$kernel->boot();

	// 	$user = new User();

	// 	$user->setUsername($resultExpected);

	// 	$em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

	// 	$result = $em->getRepository('App:User')->getUserToto($resultExpected);

	// 	$result = $result->getUsername();

	// 	$this->assertEquals($resultExpected, $result);

	// }
}
