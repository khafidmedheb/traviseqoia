<?php

namespace spec\Controller;

use Controller\ReleaseNoteController;
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
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleaseNoteControllerSpec extends ObjectBehavior
{
    // function let(Container $container, Registry $doctrine, EntityRepository $repository, EntityManager $entityManager, Request $request, FormFactory $formfactory, FormBuilder $formBuilder, Form $form, FormView $formView, Router $router )
    // {
    // 	$container->get('doctrine')->willReturn($doctrine);
    // 	$container->get('form.factory')->willReturn($formfactory);
    // 	$container->get('request')->willReturn($request);
    // 	$container->get('router')->willReturn($router);

    // 	$router->generate(Argument::cetera())->willReturn('url');

    // 	$formfactory->createBuilder(Argument::cetera())->willReturn($formBuilder);
    // 	$formBuilder->getForm(Argument::cetera())->willReturn($form);
    // 	$formfactory->create(Argument::cetera())->willReturn($form);
    // 	$form->createView()->willReturn($formView);

    // 	$doctrine->getManager()->willReturn($entityManager);
    // 	$entityManager->getRepository(Argument::any())->willReturn($repository);

    // 	$this->setContainer($container);

    // }


    // function it_is_initializable()
    // {
    //     $this->shouldHaveType('Controller\ReleaseNoteController');
    // }

    // function its_listAction_should_render_a_list_of_ReleaseObjects($entityManager, $repository, stdClass $object)
    // {
    // 	$entityManager->getRepository(Argument::exact('App:ReleaseNote'))->willReturn($repository);
    // 	$repository->findAll()->willReturn([$object]);

    // 	$this->listAction()->shouldReturn(['releases' => [$object]]);
    // }


}
