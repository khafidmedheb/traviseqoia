<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\FoodRecord;
use App\Entity\User;
use App\Entity\Contact;
use App\Form\FoodType;
use App\Form\ContactType;

/**
 * Contrôleur gérant l'application "démo" food-diary.
 * Test commit ddde la classe.
 */
class DiaryController extends Controller
{
    /**
     * Homepage de Symfony appli.
     *
     * @Route("/", name="symfo")
     */
    public function index()
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'DiaryController',
        ]);
    }

    /**
     * Homepage de Diary.
     *
     * @Route("/diary", name="homepage")
     */
    public function indexDiary()
    {
        return $this->render('diary/diary.html.twig', [
            'controller_name' => 'DiaryController',
        ]);
    }

    /**
     * @Route("/diary/list", name="diary")
     */
    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('App:FoodRecord');

        return $this->render(
            'diary/list.html.twig',
            [
                'records' => $repository->findBy(
                    [
                        'recordedAt' => new \Datetime(),
                    ]
                ),
            ]
        );
    }

    /**
     * @Route("/diary/add-new-record", name="add-new-record")
     */
    public function addRecordAction(Request $request)
    {
        $foodRecord = new FoodRecord();
        $form = $this->createForm(FoodType::class, $foodRecord);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($foodRecord);
            $em->flush();

            $this->addFlash('success', 'Une nouvelle entrée dans votre journal a bien été ajoutée.');

            return $this->redirectToRoute('add-new-record');
        }

        return $this->render('diary/addRecord.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/diary/delete-record", name="delete-record")
     */
    public function deleteRecordAction(Request $request)
    {
        if (!$record = $this->getDoctrine()->getRepository('App:FoodRecord')->findOneById($request->request->get('record_id'))) {
            $this->addFlash('danger', "L'entrée du journal n'existe pas.");

            return $this->redirectToRoute('diary');
        }

        $csrf_token = new CsrfToken('delete_record', $request->request->get('_csrf_token'));

        if ($this->get('security.csrf.token_manager')->isTokenValid($csrf_token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($record);
            $em->flush();

            $this->addFlash('success', "L'entrée a bien été supprimée du journal.");
        } else {
            $this->addFlash('error', 'An error occurred.');
        }

        return $this->redirectToRoute('diary');
    }

    public function caloriesStatusAction()
    {
        return $this->render(
            'diary/caloriesStatus.html.twig',
            ['remainingCalories' => $this->get('daily_calories')->getDailyRemainingCalories($this->getUser(), new \Datetime())]
        );
    }

    /**
     * Créer un formulaire de contact.
     *
     * @Route("/diary/contact", name="contact")
     */
    public function createContactFormAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        // Check si le formulaire est soumis
        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['nom']->getData();
            $email = $form['email']->getData();
            $subject = $form['sujet']->getData();
            $message = $form['message']->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'Un nouveau contact a bien été ajouté.');

            $myappContactMail = 'khalid.hafid-medheb@integragen.com';

            // $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 587,'tls')->setUsername('khalid.hafid-medheb@integragen.com')->setPassword('Th3sard1506');

            // $mailer = \Swift_Mailer::newInstance($transport);
            // $message = \Swift_Message::newInstance('Our Code World Newsletter')
            //    ->setFrom($myappContactMail)
            //    ->setTo($email)
            //    ->setBody($this->renderView('diary/sendemail.html.twig',array('name' => $name)),'text/html');

            // $result = $mailer->send($message);

            //Redirection vers le formulaire de contact
            return $this->redirectToRoute('contact');
        }

        return $this->render('diary/contact.html.twig', ['form' => $form->createView()]);
    }

    private function sendEmail($data)
    {
        $myappContactMail = 'khalid.hafid-medheb@integragen.com';
        $myappContactPassword = 'Thesard1506';

        //Récupération des infos saisies
        // $name = $form['nom']->getData();
        // $email = $form['email']->getData();
        // $subject = $form['sujet']->getData();
        // $message = $form['message']->getData();

        $message = \Swift_Message::newInstance()

                        ->setSubject($data['subject'])
                        ->setFrom(array($myappContactMail => 'Message by '.$data['name']))
                        ->setTo($data['email'])
                        ->setBody($this->renderView('diary/sendemail.html.twig',
                            array('name' => $data['name'])), 'text/html');

        $this->get('mailer')->send($data['message']);
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
     * Pour  tester le ROLE_ADMIN.
     *
     * @Route("/admin", name="admin")
     */
    public function testAdminAction(Request $request)
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
     * Pour  tester le ROLE_ADMIN.
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

    /**
     * @Route("/diary/ajax_request", name="ajax_request")
     *
     * @param Request $request
     *
     * @return View
     */
    public function ajaxRequestAction(Request $request)
    {
        if ($request->request->get('btnclick')) {
            $selected = $request->request->get('btnclick');

            $arrData = ['output' => 'Vous avez cliqué...',
                        'btnclick' => $selected, ];

            return new JsonResponse($arrData);
        } elseif ($request->request->get('choice')) {
            $selected = $request->request->get('choice');

            $menuData = ['output' => 'Vous avez sélectionné '.$selected,
                         'success' => true,
                         'choice' => $selected, ];

            return new JsonResponse($menuData);
        }

        return $this->render('diary/ajax/form-ajax.html.twig');
    }
}
