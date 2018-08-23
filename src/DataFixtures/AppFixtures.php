<?php

// src/DataFixtures/AppFixtures.php
// Loading fixtures : $ php bin/console doctrine:fixtures:load

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\User;
use App\Entity\Contact;
use App\Entity\FoodRecord;

class AppFixtures extends Fixture
{

    //Voir comment les users loaded "loggables" via le login de fosuserbundle
    public function loadUserData(ObjectManager $manager)
    {
        //On crée 15 utilisateurs
        for ($i = 0; $i <= 15; ++$i) {
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setEmail('userfix'.$i.'@gmail.com');
            $user->setEnabled('true');
            $user->setPassword('titi');
            $user->setRoles(array(('ROLE_ADMIN')));
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function load(ObjectManager $manager)
    {
        //On crée 15 contacts
        for ($i = 0; $i <= 16; ++$i) {
            $contact = new Contact();
            $contact->setNom('contact'.$i);
            $contact->setEmail('contactfix'.$i.'@gmail.com');
            $contact->setSujet('sujet_'.$i);
            $contact->setMessage('message_'.$i);
            $manager->persist($contact);
        }

        $manager->flush();

        //On crée 15 repas
        for ($i = 0; $i <= 16; ++$i) {
            $repas = new FoodRecord();
            $repas->setUsername('user_'.$i);
            $repas->setEntitled('Repas '.$i);
            $repas->setCalories('1000');
            $manager->persist($repas);
        }

        $manager->flush();
    }
}
