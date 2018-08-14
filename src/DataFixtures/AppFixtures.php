<?php

// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //On crée 5 utilisateurs
        for ($i = 0; $i < 7; ++$i) {
            $user = new User();
            $user->setUsername('user '.$i);
            $user->setEmail('userfix'.$i.'@gmail.com');
            $user->setPassword('toto');
            $manager->persist($user);
        }

        $manager->flush();
    }
}
