<?php

// namespace App\Tests\DataFixtures;

// use Doctrine\ORM\EntityManager;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
// use Symfony\Bundle\FrameworkBundle\Console\Application;
// use Symfony\Component\Console\Input\StringInput;
// use Symfony\Bundle\FrameworkBundle\Client;
// use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * 
 */
// class AppFixturesTest extends WebTestCase
// {
	
	/**
	 * @var Application $application
	 */
	// protected static $application;

	/**
	 * @var Client $client
	 */
	// protected $client;

	/**
	 * @var ContainerInterface $container
	 */
	// protected static $container;

	/**
	 * @var EntityManager $entityManager
	 */
	// protected $entityManager;

	/**
	 * {@inheritDoc}
	 */
	// public function setUp()
	// {
	// 	self::runCommand('doctrine:database:drop --force');
	// 	self::runCommand('doctrine:database:create');
	// 	self::runCommand('doctrine:schema:create');
	// 	self::runCommand('doctrine:fixtures:load --append --no-interaction');

	// 	$this->client = static::createClient();
	// 	$this->container = $this->client->getContainer();
	// 	$this->entityManager = $this->container->get('doctrine.orm.entity_manager');

	// 	parent::setUp();

	// }

	// protected static function runCommand($command)
	// {
	// 	$command = sprintf('%s --quiet', $command);

	// 	return self::getApplication()->run(new StringInput($command));
	// }

	// protected static function getApplication()
 //    {
 //        if (null === self::$application) {
 //        	$client = static::createClient();

 //        	self::$application = new Application($client->getKernel());
 //        	self::$application->setAutoExit(false);
 //        }

 //        return self::$application;
 //    }

    /**
     * {@inheritDoc}
     */
    // protected function tearDown()
    // {
    // 	self::runCommand('doctrine:database:drop --force');

    // 	parent::tearDown();

    // 	$this->entityManager->close();
    // 	$this->entityManager = null;
    // }

// }