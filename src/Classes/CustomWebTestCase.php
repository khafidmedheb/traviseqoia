<?php

namespace App\Classes;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\User;

abstract class CustomWebTestCase extends WebTestCase
{
    /**
     * @param array|null $roles
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected static function createAuthenticatedClient(array $roles = null)
    {
        // Assign default user roles if no roles have been passed.
        if (null == $roles) {
            $role = new Role('ROLE_SUPER_ADMIN');
            $roles = array($role);
        } else {
            $tmpRoles = array();
            foreach ($roles as $role) {
                $role = new Role($role, $role);
                $tmpRoles[] = $role;
            }
            $roles = $tmpRoles;
        }

        $user = new User('test_super_admin', 'passwd', $roles);

        return self::createAuthentication(static::createClient(), $user);
    }

    private static function createAuthentication(Client $client, User $user)
    {
        // Read below regarding config_test.yml!
        $session = $client->getContainer()->get('session');

        // Authenticate
        $firewall = 'user_area'; // This  MUST MATCH the name in your security.firewalls.->user_area<-
        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        // Save authentication
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        return $client;
    }
}
