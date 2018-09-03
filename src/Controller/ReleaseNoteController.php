<?php

namespace App\Controller;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\Routing\Router;
use \stdClass;

class ReleaseNoteController
{
    // public function setContainer($argument1)
    // {
    //     // TODO: write logic here
    // }

    /**
     * Lists all Release entities.
     *
     * @Route("/releaselist", name="release")
     * @Method("GET")
     * @Template("App:Release:list.html.twig")
     */
    public function listAction()
    {
        $em = $this->container->get('doctrine')->getManager();
        $releases = $em->getRepository('App:ReleaseNote')->findAll();

        return array(
             'releases' => $releases);

    }

    // public function setContainer($argument1)
    // {
        
    // }
}
