<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
// use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Panther\PantherTestCase;

use App\Classes\Calculator;

/**
 * Notes utilisation Travis
 *
 * 1) Les tests de soumission de formulaire passent mal sur Travis (utiliser Selenium)
 */

/**
 * Classe test pour tester :
 *
 * 1) Chargement et contenu de la Homepage
 * 2) Chargement et contenu de la page "Hello World !"
 * 3) Remplissage d'un formulaire
 * 4) Redirection d'un lien hypertexte et contenu de la page
 * 5) Exemples d'assertions (à réadapter pour notre exemple "food-diary")
 * etc...
 * Launch Phpunit : $ ./vendor/bin/simple-phpunit --filter=[Nom_de_la_méthode]
 *
 * Ou pour le test global : $ ./vendor/bin/simple-phpunit 
 *
 * Assertion : proposition que l'on propose et que l'on soutient comme vraie
 *
 */
class DiaryControllerTest extends WebTestCase
{
        
    private $client = null;
    private $clientAuth = null;
    private $clientAuthToken = null;

                                     //Tests unitaires
    
    public function testCalculator()
    {

        // Commande : ./vendor/bin/simple-phpunit --filter=testCalculator
        
        $calculator = new Calculator();

        $result = $calculator->add(30,12);

        $this->assertEquals(42, $result);
    }

    
                                     //Test authentification via FosUserBundle
    /**
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($url)
    {

        // Commande : ./vendor/bin/simple-phpunit --filter=testPageIsSuccessful
        
        //Vérifier que toutes les URL de l'appli se chargent correctement ("smoke testing")
        //Attendu : codes status HTTP entre 200 et 299
        
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function provideUrls()
    {
        return array(
            array('/diary'),
            // array('/diary/list'),
            // array('/diary/add-new-record'),
            // array('/login'),
            // array('/login_check'),
            // array('/seqoia'),
            // array('/lucky/number'),
            // array('/diary/delete-record'),
            // array('/profile/'),
            // array('/diary/contact'),
            // array('/auth'),
            // array('/logout'),
        );   
    }
                   
    /**
     * Création du client web avec les paramètres de connexion
     * 
     */
    private function logInAuth()
    {
        $clientAuth = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user10',
            'PHP_AUTH_PW'   => 'titi',
        ));
    }

                                     
    /**
     * Test login via Fosuserbundle
     * 
     */
    // public function testDoLogin()
    // {
    //     // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testDoLogin
        

    //      $data = [
    //         'username' => 'khafid',
    //         'Password' =>  'sio22'
    //     ];

    //     $client = static::createClient();

    //     $client->request(
    //         'POST', '/login', array(), array(), 
    //         array(
    //              'CONTENT_TYPE' => 'application/json',
    //     ),
    //         json_encode($data)
    //     );

    //     $this->assertEquals(200, $client->getResponse()->getStatusCode());

    //     // $this->assertTrue($client->getResponse()->isRedirect());

    //     $crawler = $client->followRedirect();

    //     $this->assertContains('Bienvenue sur Symfony 4 !', $client->getResponse()->getContent());

    //     $username = "khafid";
    //     $password = "sio22";
        
    //     $client = static::createClient();

    //     $crawler = $client->request('GET', '/login');

    //     $form = $crawler->filter('form')->form();

    //     $crawler = $client->submit($form, array(
    //         '_username'  => $username,
    //         '_password'  => $password,
    //     )); 

    //     dump($form); die();

    //    $client->submit($form);

    //    $this->assertTrue($client->getResponse()->isRedirect());

    //    $crawler = $client->followRedirect();

    //    Test soumission formulaire
    //    $this->assertRegexp('/Invalid credentials?/', $crawler->filter('div.alert.alert-success')->first()->text());
    //    $this->assertContains('Bienvenue sur Symfony 4 !', $client->getResponse()->getContent());
    //     $username = "";
    //     $password = "";

    //     $client = static::createClient();

    //     $client->request(
    //         'POST', 
    //         '/login', 
    //         array(), 
    //         array(), 
    //         array(
    //              'CONTENT_TYPE' => 'application/json',
    //              'PHP_AUTH_USER' => $username,
    //              'PHP_AUTH_PW4' => $password,
    //         )
    //     );

    //     $this->assertEquals(200, $client->getResponse()->getStatusCode());
    // }


                                       //Tests sur le register


    /**
     * Test l'enregistrement d'un nouvel utilisateur depuis le register de Fosuserbundle via la requête Json
     * 
     */
    // public function testRegisterNewUserViaJsonRequest()
    // {
    //     // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testRegisterNewUserViaJsonRequest

    //     $data = [
    //         'email' =>'khalid.hafid-medheb@integragen.com',
    //         'username' => 'TITUS',
    //         'plainPassword' => [
    //             'first' => 'TOTO1506', 'second' => 'TOTO1506'
    //         ]
    //     ];

    //     $client = $this->fillPOSTRequest($data);

    //     $JSON_response = json_decode($client->getResponse()->getContent(), true);

    //     $this->assertEquals($JSON_response["email"], "khalid.hafid-medheb@integragen.com" );
    //     $this->assertEquals($JSON_response["username"], "TITUS" );
    //     $this->assertEquals($JSON_response["plainPassword"]["first"], "TOTO1506" );
    //     $this->assertEquals($JSON_response["plainPassword"]["second"], "TOTO1506" );

    //     $this->assertEquals(200, $client->getResponse()->getStatusCode());
    // }

    /**
     * Test d'un register vide
     * 
     */
    public function testEmptyRegister()
    {
        // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testEmptyRegister
        
        $client = static::createClient();

        $crawler = $client->request('GET', '/register/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        
        // Remplissage du formulaire
        $form = $crawler->selectButton('Register')->form();

        $form->setValues(array(
            'fos_user_registration_form[email]' => '',
            'fos_user_registration_form[username]' => '',
            'fos_user_registration_form[plainPassword][first]' => '',
            'fos_user_registration_form[plainPassword][second]' => '',
            )
        );

        $client->submit($form);

        //Pas de redirection : un code status 200 au lieu de 302
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }


    /**
     * Test l'enregistrement d'un nouvel utilisateur depuis le register de Fosuserbundle
     * 
     */
    public function testRegisterNewUser()
    {
        // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testRegisterNewUser
        
        $client = static::createClient();
        // $client->followRedirects(); 

        $crawler = $client->request('GET', '/register/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        
        // Remplissage du formulaire
        $form = $crawler->selectButton('Register')->form();
        
        $i = random_int(0, 1000);
        $form->setValues(array(
            // 'fos_user_registration_form[email]' => 'test@gmail.com',
            'fos_user_registration_form[email]' => 'test' .$i. '@gmail.com',
            // 'fos_user_registration_form[username]' => 'Test nom',
            'fos_user_registration_form[username]' => 'Test nom ' .$i. '',
            'fos_user_registration_form[plainPassword][first]' => 'toto',
            'fos_user_registration_form[plainPassword][second]' => 'toto',
            )
        );

        $client->submit($form);

        //Test du submit du formulaire
        $this->assertSame(302, $client->getResponse()->getStatusCode());

        // $this->assertContains('The user has been created successfully.', $client->getResponse()->getContent());
        // $this->assertContains('Congrats Test nom, your account is now activated.', $client->getResponse()->getContent());
    }


    /**
     * Test l'enregistrement d'un nouvel utilisateur depuis le register de Fosuserbundle
     * 
     */
    public function testRegisterNewUserWithInvalidMail()
    {
        // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testRegisterNewUserWithInvalidMail
        
        $client = static::createClient();

        $crawler = $client->request('GET', '/register/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        
        // Remplissage du formulaire
        $form = $crawler->selectButton('Register')->form();

        $form->setValues(array(
            'fos_user_registration_form[email]' => 'test2gmail.com',
            'fos_user_registration_form[username]' => 'Test nom 2',
            'fos_user_registration_form[plainPassword][first]' => 'toto',
            'fos_user_registration_form[plainPassword][second]' => 'toto',
            )
        );

        $client->submit($form);

        //Test du submit du formulaire
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Quand l'email existe déjà, le formulaire
     * 
     */
    public function testRegisterWithMailAndNameAlreadyUsed()
    {
        // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testRegisterWithMailAndNameAlreadyUsed
        
        $client = static::createClient();

        $crawler = $client->request('GET', '/register/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        
        // Remplissage du formulaire
        $form = $crawler->selectButton('Register')->form();

        $form->setValues(array(
            'fos_user_registration_form[email]' => 'userfix10@gmail.com',
            'fos_user_registration_form[username]' => 'user10',
            'fos_user_registration_form[plainPassword][first]' => 'titi',
            'fos_user_registration_form[plainPassword][second]' => 'titi',
            )
        );

        $client->submit($form);

        //Test du submit du formulaire
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertContains('The email is already used.', $client->getResponse()->getContent());
        $this->assertContains('The username is already used.', $client->getResponse()->getContent());

    }

    /**
     * Test un Register vide
     *
     */
    // public function testEmptyRegisterViaJsonRequest()
    // {
    //     // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testEmptyRegisterViaJsonRequest

    //     $data = [
    //         'email' => '',
    //         'username' => '',
    //         'plainPassword' => [
    //             'first' => '', 'second' => ''
    //         ]

    //     ];

    //     $client = $this->fillPOSTRequest($data);

    //     $JSON_response = json_decode($client->getResponse()->getContent(), true);

    //     $this->assertEquals($JSON_response["email"], "" );
    //     $this->assertEquals($JSON_response["username"], "" );
    //     $this->assertEquals($JSON_response["plainPassword"], "" );
    //     $this->assertEquals($JSON_response["first"], "" );
    //     $this->assertEquals($JSON_response["second"], "" );

    //     //Pas de redirection : un code status 200 au lieu de 302
    //     $this->assertSame(200, $client->getResponse()->getStatusCode());

    // }

    
    /**
     * Test d'un user avec email invalide -> affichage d'une erreur 400
     *
     */
    // public function testRegisterNewUserWithInvalidMail()
    // {
    //     // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testRegisterNewUserWithInvalidMail

    //     $data = [
    //         'email' => 'khalid.hafid-medhebintegragen.com',
    //         'username' => 'TITI',
    //         'plainPassword' => [
    //             'first' => 'TOTO1506', 'second' => 'TOTO1506'
    //         ]

    //     ];

    //     $client = $this->fillPOSTRequest($data);

    //     $this->assertEquals(200, $client->getResponse()->getStatusCode());

    //     $JSON_response = json_decode($client->getResponse()->getContent(), true);

    //     $this->assertEquals($JSON_response["email"], "khalid.hafid-medhebintegragen.com" );
    //     $this->assertEquals($JSON_response["username"], "TITI" );
    //     $this->assertEquals($JSON_response["plainPassword"]["first"], "TOTO1506" );
    //     $this->assertEquals($JSON_response["plainPassword"]["second"], "TOTO1506" );
    // }


    /**
     * Remplissage automatique des données du formulaire "Register"
     */
    // private function fillPOSTRequest($data)
    // {
    //     $client = static::createClient();

    //     $client->request(
    //         'POST', '/register/', array(), array(), 
    //         array(
    //              'CONTENT_TYPE' => 'application/json',
    //     ),
    //         json_encode($data)
    //     );

    //     return $client;

    // }
                           

                                     //Test authentification via FosUserBundle


    // public function testAuthentication()
    // {
    //     // ./vendor/bin/simple-phpunit --filter=testAuthentication
    
    //     $clientAuth = static::createClient(array(), array(
    //         'PHP_AUTH_USER' => 'user10',
    //         'PHP_AUTH_PW'   => 'titi',
    //     ));

    //     $crawler = $clientAuth->request('GET', '/', array(), array(), array(
    //         'PHP_AUTH_USER' => 'user10',
    //         'PHP_AUTH_PW'   => 'titi',
    //     ));

    //     // $this->assertEquals(
    //     //     'App\Controller\DiaryController::index',
    //     //     $clientAuth->getRequest()->attributes->get('_controller')
    //     // );
 
    //     // Verification http de la redirection.
    //     $this->assertSame(Response::HTTP_OK, $clientAuth->getResponse()->getStatusCode());
 
    //     // Verification si c'est la bonne page.
    //     $this->assertContains('Bienvenue sur Symfony 4 !', $clientAuth->getResponse()->getContent());


    //     //Homepage Diary
    //     $crawler = $clientAuth->request('GET', '/diary', array(), array(), array(
    //         'PHP_AUTH_USER' => 'user10',
    //         'PHP_AUTH_PW'   => 'titi',
    //     ));

 
    //     $this->assertEquals(
    //         'App\Controller\DiaryController::indexDiary',
    //         $clientAuth->getRequest()->attributes->get('_controller')
    //     );
 
    //     // Verification http de la redirection.
    //     $this->assertSame(Response::HTTP_OK, $clientAuth->getResponse()->getStatusCode());
 
    //     // Verification si c'est la bonne page.
    //     $this->assertContains('Bienvenue sur FoodDiary !', $clientAuth->getResponse()->getContent());


    //     //Liste des repas -> HS
    //     $crawler = $clientAuth->request('GET', '/diary/list', array(), array(), array(
    //         'PHP_AUTH_USER' => 'testname',
    //         'PHP_AUTH_PW'   => 'toto',
    //     ));

 
    //     $this->assertEquals(
    //         'App\Controller\DiaryController::listAction',
    //         $clientAuth->getRequest()->attributes->get('_controller')
    //     );
 
    //     // Verification http de la redirection.
    //     $this->assertSame(Response::HTTP_OK, $clientAuth->getResponse()->getStatusCode());
 
    //     // Verification si c'est la bonne page.
    //     $this->assertContains('Liste de tous les rapports', $clientAuth->getResponse()->getContent());


    //     //Page de contact
    //     $crawler = $clientAuth->request('GET', '/diary/contact', array(), array(), array(
    //         'PHP_AUTH_USER' => 'user10',
    //         'PHP_AUTH_PW'   => 'titi',
    //     ));

 
    //     $this->assertEquals(
    //         'App\Controller\DiaryController::createContactFormAction',
    //         $clientAuth->getRequest()->attributes->get('_controller')
    //     );
 
    //     // Verification http de la redirection.
    //     $this->assertSame(Response::HTTP_OK, $clientAuth->getResponse()->getStatusCode());
 
    //     // Verification si c'est la bonne page.
    //     $this->assertContains('Formulaire de contact', $clientAuth->getResponse()->getContent());

    // }


    public function setUp()
    {
         // $this->clientAuthToken = static::createClient(array('debug' => true));

        $this->clientAuth = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user10',
            'PHP_AUTH_PW'   => 'titi',
        ));

    }


    public function testLoginWithToken()
    {
        
        // ./vendor/bin/simple-phpunit --filter=testLoginWithToken

        $this->logIn();

        // Interrogation de la page de bienvenue
        $crawler = $this->clientAuth->request('GET', '/welcome');
 
        $this->assertEquals(
            'App\Controller\DiaryController::index',
            $this->clientAuth->getRequest()->attributes->get('_controller')
        );
 
        // Verification http de la redirection.
        $this->assertSame(Response::HTTP_OK, $this->clientAuth->getResponse()->getStatusCode());
 
        // Verification si c'est la bonne page.
        $this->assertContains('Bienvenue sur Symfony 4 !', $this->clientAuth->getResponse()->getContent());

    }

    
    private function logIn()
    {
        $session = $this->clientAuth->getContainer()->get('session');
 
        // the firewall context (defaults to the firewall name)
        $firewall = 'main';
 
        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        echo $session->getId();
        $cookie = new Cookie($session->getName(), $session->getId());
        $this->clientAuth->getCookieJar()->set($cookie);
    }


                                    //Test du chargement et du contenu de la Homepage
    
    /**
     * Teste le contenu de la homepage
     * 
     */
    public function testHomepageContent()
    {
        // Commande : ./vendor/bin/simple-phpunit --filter=testHomepageContent
        
                                //Création d'un client navigateur HTTP (objet)
              
        $client = static::createClient();

        // $client = $this->makeClient();

        //Objet Crawler (API) qui va permmettre de naviguer dans la page d'accueil
        //On extrait les infos d'une page web via l'objet crawler
        $crawler = $client->request('GET', '/diary');

                                    //Test chargement de la Homepage
                        
        // Code status de la forme 2xx
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');

        // Code status 200 renvoyé (chargement de la page)
        $this->assertSame(200, $client->getResponse()->getStatusCode());


                                           //Test : contenus des liens et si hypertexte
                                    
        $this->assertContains(
            'Food diary', 
            $client->getResponse()->getContent()
        );

        $link = $crawler->filter('a:contains("Food diary")')->first()->link();
        $uri = $link->getUri();
        $this->assertEquals('http://localhost/diary', $uri);

        $this->assertContains(
            'Ajouter un nouveau rapport', 
            $client->getResponse()->getContent()
        );

        $link = $crawler->selectLink('Ajouter un nouveau rapport')->link();

        // $crawler->filter('a:contains("Ajouter un nouveau rapport")')->first()->link();
        $uri = $link->getUri();
        $this->assertEquals('http://localhost/diary/add-new-record', $uri);

        $this->assertContains(
            'Voir tous les rapports', 
            $client->getResponse()->getContent()
        );

        // $crawler->filter('a:contains("Voir tous les rapports")')->first()->link();
        $link = $crawler->selectLink('Voir tous les rapports')->link();
        $uri = $link->getUri();
        $this->assertEquals('http://localhost/diary/list', $uri);

        $this->assertContains(
            'Liste des rapports', 
            $client->getResponse()->getContent()
        );

        // $crawler->filter('a:contains("Liste des rapports")')->first()->link();
        $link = $crawler->selectLink('Liste des rapports')->link();
        $uri = $link->getUri();
        $this->assertEquals('http://localhost/diary/list', $uri);

        // $this->assertContains(
        //     'Lien vers Google', 
        //     $client->getResponse()->getContent()
        // );

        // $crawler->filter('a:contains("Lien vers Google")')->first()->link();
        // $link = $crawler->selectLink('Lien vers Google')->link();
        // $uri = $link->getUri();
        // $this->assertEquals('https://www.google.fr/', $uri);


                                    //Test : contenus de la Homepage
                                    
        $this->assertContains('Bienvenue sur FoodDiary', $client->getResponse()->getContent());
        
        //Test du titre principal
        $heading = $crawler->filter('h1')->eq(0)->text();
        $this->assertEquals('Bienvenue sur FoodDiary !', $heading);

        $this->assertRegExp('/Vous devez vous connecter?/', $client->getResponse()->getContent());

        //Tests sur liste
        //$heading = $crawler->filter('h1')->eq(0)->text();
        
        $this->assertRegExp('/Copyright?/', $client->getResponse()->getContent());

        //Si le c entouré après Copyright est présent
        $this->assertContains('&copy;', $client->getResponse()->getContent());

        $this->assertRegExp('/2018/', $client->getResponse()->getContent());

                                    //Test de balises HTML
                                    
        //Test : la Homepage contient une balise titre principal <h1>
        
        // Une balise div avec la class "col-lg-12"
        $this->assertGreaterThan(
            0,
            $crawler->filter('div.col-lg-12')->count()
        );

        $this->assertCount(1, $crawler->filter('h1'));

        $this->assertCount(1, $crawler->filter('h2'));

        $this->assertCount(1, $crawler->filter('h3'));

        $this->assertCount(1, $crawler->filter('h6'));


                            //Test du lien vers Google
    
        //On récupère ici l'objet lien
        // $linkGoogle = $crawler->filter('div > a:contains("Lien vers Google")')->first()->link();
        // 
        //Simulation du clic et ouverture de la page correspondante
        // $googlePage = $client->click($linkGoogle);
        
        //Test si le titre principal est 'Liste de tous les rapports'
        // $this->assertEquals('Afficher la page d\'accueil de Google', $googlePage->filter('h1')->first()->text());


                                    //Test insertion Image
        
        //Test du titre principal
        // dump($crawler->filter('img')->attr('alt')); die();
        // $altImage = $crawler->filter('img')->attr('alt');


        // $this->assertEquals('paris-brest', $altImage);

        // $imagesCrawler = $crawler->filter('img')->alt();

        // $this->assertEquals('paris-brest', $imagesCrawler);
        
    }

    
    /**
     * Test de la redirection des liens hypertexte et le chargement des pages correspondantes
     * 
     */
    public function testLinks()
    {
        // Commande : ./vendor/bin/simple-phpunit --filter=testLinks
        
        $client = static::createClient();
        // $client = static::createPantherClient();

        // $client = $this->makeClient();

        //Test des liens de la Homepage
        $crawler = $client->request('GET', '/diary');

        // Code status 200 renvoyé (chargement de la page)
        $this->assertSame(200, $client->getResponse()->getStatusCode());

                            //Test : contenus des liens
                                    
        $this->assertContains(
            'Food diary', 
            $client->getResponse()->getContent()
        );

        $this->assertContains(
            'Ajouter un nouveau rapport', 
            $client->getResponse()->getContent()
        );

        $this->assertContains(
            'Voir tous les rapports', 
            $client->getResponse()->getContent()
        );

        $this->assertContains(
            'Ajax', 
            $client->getResponse()->getContent()
        );

        $this->assertContains(
            'Contact', 
            $client->getResponse()->getContent()
        );
   
        
                            //Test : redirection des liens de la navbar

        //Test lien "Food diary"
        $linkFoodDiary = $crawler->filter('a:contains("Food diary")')->first()->link();

        //Simulation du clic et ouverture de la page correspondante
        $foodDiary = $client->click($linkFoodDiary);

        //Test si le titre principal est 'Bienvenue sur FoodDiary !'
        $this->assertEquals('Bienvenue sur FoodDiary !', $foodDiary->filter('h1')->first()->text());

        //Test 1 du contenu
        $this->assertRegExp('/Vous devez vous connecter?/', $foodDiary->filter('p')->first()->text());

        //Test 2 du contenu
        $this->assertRegExp('/Copyright?/', $foodDiary->filter('footer > div > div p')->first()->text());

       
        //Test lien "Ajouter un nouveau rapport"
        $linkAddReport = $crawler->filter('a:contains("Ajouter un nouveau rapport")')->first()->link();

        //Simulation du clic et ouverture de la page correspondante
        $addReport = $client->click($linkAddReport);

        //Test si le titre principal est 'Ajouter un repas'
        $this->assertEquals('Ajouter un repas', $addReport->filter('h1')->first()->text());

        //Test 1 pour vérifier bouton "Ajouter"
        $this->assertEquals('Ajouter', $addReport->filter('button.pull-right')->first()->text());

        //Test 2 si le label "Ton nom ?" existe
        $this->assertEquals(1, $addReport->filter('label:contains("Ton nom ?")')->count() );

        $this->assertContains(
            'Voir tous les rapports', 
            $client->getResponse()->getContent()
        );
        
        //Test lien "Voir tous les rapports"
        $link = $crawler->filter('a:contains("Voir tous les rapports")')->first()->link();

        //Simulation du clic et ouverture de la page correspondante
        $listPage = $client->click($link);

        //Test si le titre principal est 'Liste de tous les rapports'
        // $this->assertEquals('Liste de tous les rapports', $listPage->filter('h1.page-header')->first()->text());

        //Test 1 si aucun rapport n'est affiché
        // $this->assertEquals('Aucune entrée dans le journal pour l\'instant.', $listPage->filter('p')->first()->text());

        // $this->assertEquals('Ajouter une nouvelle entrée', $listPage->filter('button:contains("Ajouter une nouvelle entrée")')->first()->text());
       
        
        //Test lien onglet "Ajax"
        $linkAjax = $crawler->filter('a:contains("Ajax")')->first()->link();

        //Simulation du clic et ouverture de la page correspondante
        $PageAjax = $client->click($linkAjax);

        $this->assertEquals('Formulaire test Ajax', $PageAjax->filter('h2')->first()->text());

        $this->assertEquals('Bouton test Ajax', $PageAjax->filter('h3')->first()->text());

        $this->assertEquals('Liste déroulante test Ajax !', $PageAjax->filter('h4')->first()->text());

        //Test lien onglet "Contact"
        $linkContact = $crawler->filter('a:contains("Contact")')->first()->link();

        //Simulation du clic et ouverture de la page correspondante
        $PageContact = $client->click($linkContact);

        //Test si le titre principal est 'Formulaire de contact'
        $this->assertEquals('Formulaire de contact', $PageContact->filter('h1')->first()->text());
        
        //Test lien vers compte Github (connexion)

        //Test lien vers un site web/service externe (connexion)

    }

    
    /**
     * Test du formulaire d'ajout de repas de food-diary
     * 
     */
    public function testForm()
    {
        // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testForm

        $client = static::createClient();

        $crawler = $client->request('GET', '/diary/add-new-record');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $crawler = $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Test formulaire vide
        $form = $crawler->selectButton('Ajouter')->form();

        $form->setValues(array(
            'food[username]' => '',
            'food[entitled]' => '',
            'food[calories]' => '',
            )
        );

        $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Remplissage du formulaire
        $form = $crawler->selectButton('Ajouter')->form();

        $form->setValues(array(
            'food[username]' => 'Test nom',
            'food[entitled]' => 'Test nom repas',
            'food[calories]' => 99999,
            )
        );

        $client->submit($form);

        //Test du submit du formulaire
        $this->assertSame(302, $client->getResponse()->getStatusCode());

        // Test "nom" vide
        $form = $crawler->selectButton('Ajouter')->form();

        $form->setValues(array(
            'food[username]' => '',
            'food[entitled]' => 'Test nom repas',
            'food[calories]' => 88888,
            )
        );

        $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Test "repas" vide
        $form = $crawler->selectButton('Ajouter')->form();

        $form->setValues(array(
            'food[username]' => 'Test nom',
            'food[entitled]' => '',
            'food[calories]' => 77777,
            )
        );

        $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Test "calories" vide
        $form = $crawler->selectButton('Ajouter')->form();

        $form->setValues(array(
            'food[username]' => 'Test nom',
            'food[entitled]' => 'Test repas',
            'food[calories]' => '',
            )
        );

        $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Test valeurs incorrectes
        $form = $crawler->selectButton('Ajouter')->form();

        $form->setValues(array(
            'food[username]' => 123,
            'food[entitled]' => 456,
            'food[calories]' => 'Pas bon !',
            )
        );

        $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // TODO : Test Database record
        
        // TODO : Tests erreurs
    }


    /**
     * Test de l'accès au formulaire "Ajouter un repas" depuis la Homepage
     * 
     * Se rendre sur le formulaire depuis la Homepage
     * Remplir les éléments du formulaire avec des valeurs
     * Soumettre le formulaire
     * Vérifier que la réponse au client contient une notification de réussite d’envoi
     * 
     */
    public function testGoToFormRepas()
    {
        // Commande : ./vendor/bin/simple-phpunit --filter=testGoToFormRepas

        $client = static::createClient();

        $crawler = $client->request('GET', '/diary');

        $this->assertEquals(1, $crawler->filter('h1:contains("Bienvenue sur FoodDiary !")')->count());

        //Accès au formulaire depuis l'onglet "Ajouter un nouveau rapport"
        $linkAddReport = $crawler->filter('a:contains("Ajouter un nouveau rapport")')->first()->link();

        //Simulation du clic et ouverture de la page correspondante
        $addReport = $client->click($linkAddReport);

        //Test si le titre principal est 'Ajouter un repas'
        $this->assertEquals(1, $addReport->filter('h1:contains("Ajouter un repas")')->count());

        //On select le form via le bouton 'Ajouter' : mon crawler représente le bouton
        $form = $addReport->selectButton('Ajouter')->form();

        $form->setValues(array(
            'food[username]' => 'Chris',
            'food[entitled]' => 'Potage',
            'food[calories]' => 2000558,
            )
        );

        $client->submit($form);

        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    /**
     * Test l'ajout d'un rapport (repas) depuis la page liste
     * 
     * Cliquer sur le bouton "Ajouter une nouvelle entrée"
     * Le formulaire "Ajouter un repas" s'affiche
     * Remplir les éléments du formulaire avec des valeurs
     * Soumettre le formulaire
     * Vérifier que la réponse au client contient une notification de réussite d’envoi
     * 
     */
    // public function testAddReportFromList()
    // {
    //     // Commande: ./vendor/bin/simple-phpunit --filter=testAddReportFromList

    //     $client = static::createClient();

    //     $crawler = $client->request('GET', '/diary/list');

    //     $this->assertEquals(1, $crawler->filter('h1:contains("Liste de tous les rapports")')->count());

    //     $this->assertContains('Liste de tous les rapports', $client->getResponse()->getContent());

    //     //Test quand la liste est vide
    //     $this->assertContains('Ajouter une nouvelle entrée', $client->getResponse()->getContent());

    //     //On select le form via le bouton 'Ajouter' : mon crawler représente le bouton
    //     $form = $crawler->selectButton('Ajouter une nouvelle entrée')->form();

    //     $addReport = $client->submit($form);

    //     //Test si le titre principal est 'Ajouter un repas'
    //     $this->assertEquals(1, $addReport->filter('h1:contains("Ajouter un repas")')->count());

    //     //On select le form via le bouton 'Ajouter' : mon crawler représente le bouton
    //     $form = $addReport->selectButton('Ajouter')->form();

    //     $form->setValues(array(
    //         'food[username]' => 'Jean',
    //         'food[entitled]' => 'Tarte aux fraises',
    //         'food[calories]' => 85962,
    //         )
    //     );

    //     $client->submit($form);

    //     $this->assertSame(302, $client->getResponse()->getStatusCode());

    // }


    /**
     * Test la suppression d'un rapport depuis la page liste
     *
     * Aller sur la vue "Voir tous les rapports"
     * Cliquer sur le bouton "Supprimer"
     * Le rapport est supprimé
     * Vérifier que la réponse au client contient une notification de suppression
     * 
     */
    // public function testDeleteReport()
    // {
    //     // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testDeleteReport

    //     //On requête la page qui affiche le formulaire
    //     $client = static::createClient();

    //     $crawler = $client->request('GET', '/diary/list');

    //     $this->assertEquals(1, $crawler->filter('h1:contains("Liste de tous les rapports")')->count());

    //     //On select le form via le bouton 'Ajouter' : mon crawler représente le bouton
    //     $form = $crawler->selectButton('Supprimer')->form();

    //     $deleteReport = $client->submit($form);

    //     //Suivre la redirection vers le formulaire
    //     $deleteReport = $client->followRedirect(); 

    //     //Test soumission formulaire
    //     $this->assertRegexp('/L\'entrée a bien été?/', $deleteReport->filter('div.alert.alert-success')->first()->text());

    // }


    /**
     * Test du formulaire de contact de food-diary
     * 
     */
    public function testContactForm()
    {
        // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testContactForm

        $client = static::createClient();

        $crawler = $client->request('GET', '/diary/contact');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //Test champs vides
        $form = $crawler->selectButton('Envoyer')->form();

        $form->setValues(array(
            'contact[nom]' => '',
            'contact[sujet]' => '',
            'contact[email]' => '',
            'contact[message]' => '',
            )
        );

        $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //Test formulaire rempli
        $form = $crawler->selectButton('Envoyer')->form();

        $form->setValues(array(
            'contact[nom]' => 'Test nom contact',
            'contact[sujet]' => 'Test sujet contact',
            'contact[email]' => 'testmailcontact@gmail.com',
            'contact[message]' => 'Test message contact',
            )
        );

        $client->submit($form);

        $this->assertSame(302, $client->getResponse()->getStatusCode());

        //Test valeurs erronées
        $form = $crawler->selectButton('Envoyer')->form();
        $crawler = $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //Test invalid data
        $form = $crawler->selectButton('Envoyer')->form();

        $form->setValues(array(
            'contact[nom]' => 123,
            'contact[sujet]' => 456,
            'contact[email]' => 'fake_mail',
            'contact[message]' => 789,
            )
        );

        $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //Test mail au format incorrect
        $form = $crawler->selectButton('Envoyer')->form();

        $form->setValues(array(
            'contact[nom]' => 'Test nom contact',
            'contact[sujet]' => 'Test sujet contact',
            'contact[email]' => 'invalid_mail',
            'contact[message]' => 'Test message contact',
            )
        );

        $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //TODO : Test envoi mail

    }

    
    public function testNoPageFound ()
    {
        // Commande : ./vendor/bin/simple-phpunit --filter=testNoPageFound

        $client = static::createClient();

        $crawler = $client->request('GET', '/pas-de-page');

        // Code status 404 si la page n'existe pas
        $this->assertTrue($client->getResponse()->isNotFound());
    }

    /**
     *  Asserts that the response is 404
     */
    public function testPageNotFound()
    {
        
        // Commande : ./vendor/bin/simple-phpunit --filter=testPageNotFound
        
        $client = static::createClient();

        $crawler = $client->request('GET', '/error-404');

        $this->assertTrue($client->getResponse()->isNotFound());


    }


                          //Test : codes Jquery avec Ajax
    /**
     * Test du bouton "Ajax"
     * 
     */
    public function testButtonAjax()
    {

        // Commande : ./vendor/bin/simple-phpunit --filter=testButtonAjax
        
        $client = static::createClient();

        $crawler = $client->request('GET', '/diary/ajax_request');

        // Code status 200 renvoyé (chargement de la page)
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertEquals('Click me !', $crawler->filter('button.ajax')->first()->text());
        
        $this->assertEquals('Here comes the result', $crawler->filter('div#ajax-results')->first()->text());
 
        $dataTest = ['btnclick' => true];
       
        $clientAjax = static::createClient();

        $client->request(
            'POST',
            '/diary/ajax_request',
            $dataTest,
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );
        
        $JSON_response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($JSON_response["btnclick"], true);
        $this->assertRegExp('/Vous avez cliqué...?/', $JSON_response["output"]);
    }

    /**
     * Test du menu déroulant "Ajax"
     * 
     */
    public function testMenuAjax()
    {

        // Commande : ./vendor/bin/simple-phpunit --filter=testMenuAjax
        
        $client = static::createClient();

        $crawler = $client->request('GET', '/diary/ajax_request');

        // Code status 200 renvoyé (chargement de la page)
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertContains('Liste déroulante test Ajax !', $crawler->filter('h4')->first()->text());
 
        $dataTest = ['btnclick' => 'Cliquez !'];
       
        $clientAjax = static::createClient();

        $client->request(
            'POST',
            '/diary/ajax_request',
            $dataTest,
            array(),
            array('CONTENT_TYPE' => 'application/json')
        );

        // asserts that the "Content-Type" header is "application/json"
        $this->assertTrue(
            $client->getResponse()->headers->contains(
               'Content-Type',
               'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
);


        $JSON_response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($JSON_response["btnclick"], "Cliquez !" );
        $this->assertRegExp('/Vous avez cliqué...?/', $JSON_response["output"]);

    }
}
