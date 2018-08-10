<?php
// src/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function listUsers()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAllOrderedByName();
    }

    public function testFindUserToto()
    {
        // Commande : ./vendor/bin/simple-phpunit --filter=testQuery

        $nom = "Toto";

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->getUserToto($nom);
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
