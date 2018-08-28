<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\JsonResponse;
// use App\Entity\FoodRecord;
// use App\Entity\User;
// use App\Entity\Contact;
// use App\Form\FoodType;
// use App\Form\ContactType;

/**
 * Contrôleur gérant la page d'admin
 *
 */
class AdminController extends Controller
{
    
    /**
     * Pour tester le ROLE_ADMIN.
     *
     * @Route("/admin", name="admin")
     */
    public function indexAdmin(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //Va modifier l'email de l'utilisateur connecté
        // $user = $this->getUser()->setEmail('khafid1506@gmail.com');

        // $em = $this->getDoctrine()->getManager();
        // $em->persist($user);
        // $em->flush;

        return $this->render('admin/admin.html.twig');
    }

    
    /**
     * Pour  tester le ROLE_USER.
     *
     * @Route("/user/test", name="testRoleUser")
     */
    public function testRoleAction(Request $request)
    {
        return $this->render('roles/hello-world.html.twig');
    }


    /**
     * Pour tester le ROLE_ADMIN.
     *
     * @Route("/admin/test", name="testRoleAdmin")
     */
    public function testRoleAdminAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //Va modifier l'email de l'utilisateur connecté
        // $user = $this->getUser()->setEmail('khafid1506@gmail.com');

        // $em = $this->getDoctrine()->getManager();
        // $em->persist($user);
        // $em->flush;

        return $this->render('roles/hello-world-admin.html.twig');
    }

    
}
