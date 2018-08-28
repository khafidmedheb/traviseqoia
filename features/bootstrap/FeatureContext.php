<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Mink\Driver\BrowserKitDriver;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * This context class contains the definitions of the steps used by the demo 
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 * 
 * @see http://behat.org/en/latest/quick_start.html
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var Response|null
     */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path)
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived()
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
    }

    /**
     * 
     * @Given /^I am on login page$/
     */
    // public function iAmOnLoginPage()
    // {
    //     $this->visit('/login');
    //     $this->fillField('username', 'testadmin');
    //     $this->fillField('password', 'titi');
    //     $this->pressButton('Log in');
    //     // make assertion to be sure user is logged in
    // }
    


    /**
     * @Given /^I am logged in as admin$/
     */
    public function iAmLoggedInAsAdmin()
    {
        $this->visit('/login');
        $this->fillField('username', 'testadmin');
        $this->fillField('password', 'titi');
        $this->pressButton('Log in');
        $this->visit('/');

        // make assertion to be sure user is logged in
    }

    /**
     * @Given /^I am logged in as user$/
     */
    public function iAmLoggedInAsUser()
    {
        $this->visit('/login');
        $this->fillField('username', 'testuser');
        $this->fillField('password', 'titi');
        $this->pressButton('Log in');
        $this->visit('/');
        // make assertion to be sure user is logged in
    }
  
}
