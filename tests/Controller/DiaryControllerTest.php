<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
// use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use App\Classes\Calculator;


/**
 * Classe test pour tester :
 *
 * 1) Chargement et contenu de la Homepage
 * 2) Chargement et contenu de la page "Hello World !"
 * 3) Remplissage d'un formulaire
 * 4) Redirection d'un lien hypertexte et contenu de la page
 * 5) Exemples d'assertions (à réadapter pour notre exemple "food-diary")
 *
 * Launch Phpunit : $ ./vendor/bin/phpunit --filter=testHomepageIsUp [ > web/resultTest.html ]
 *
 * Liste des routes : $ php bin/console debug:router
 *
 * Test de la route homepage : $ php bin/console debug:router homepage
 *
 * Test Phpunit global : $ ./vendor/bin/phpunit.bat
 *
 * Assertion : proposition que l'on propose et que l'on soutient comme vraie
 *
 * Config PhpUnit (Symfony 4) : $ composer require --dev symfony/phpunit-bridge
 *
 */
class DiaryControllerTest extends WebTestCase
{
        
    private $client = null;
    private $clientAuth = null;
    private $clientAuthToken = null;


    public function testCalculator()
    {

        // Commande : ./vendor/bin/simple-phpunit --filter=testSum
        
        $calculator = new Calculator();

        $result = $calculator->add(30,12);

        $this->assertEquals(42, $result);
    }

    //Vérifier que toutes les URL de l'appli se chargent correctement ("smoke testing")
    //Attendu : codes status HTTP entre 200 et 299
    
    /**
     * @dataProvider provideUrls
     */
    public function testPageIsSuccessful($url)
    {

        // Commande : ./vendor/bin/simple-phpunit --filter=testPageIsSuccessful
        
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function provideUrls()
    {
        return array(
            array('/diary'),
            array('/diary/list'),
            array('/diary/add-new-record'),
            array('/login'),
            array('/seqoia'),
            array('/lucky/number'),
            array('/diary/delete-record'),
            // array('/diary/contact'),
            // array('/auth'),
            // array('/logout'),
        );   
    }


    //Test authentification via FosUserBundle
    

    private function logInAuth()
    {
    
        $clientAuth = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'khafid',
            'PHP_AUTH_PW'   => 'sio22',
        ));

    }
 
    public function setUp()
    {
         // $this->clientAuthToken = static::createClient(array('debug' => true));

        $this->clientAuth = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'khafid',
            'PHP_AUTH_PW'   => 'sio22',
        ));

    }

    public function testLoginForm ()
    {
        // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testLoginForm

        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        // dump($crawler); die();

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Test formulaire vide
        $form = $crawler->selectButton('Log in')->form();

        $form->setValues(array(
            'login[_username]' => 'khafid',
            'login[_password]' => 'sio22',
            )
        );

        $client->submit($form);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

   
    public function testLoginWithToken()
    {
        
        // ./vendor/bin/simple-phpunit --filter=testLoginWithToken

        $this->logIn();

        // $this->logInFaster();

        // Interrogation de la page de bienvenue
        $crawler = $this->clientAuth->request('GET', '/');
 
        $this->assertEquals(
            'App\Controller\DiaryController::index',
            $this->clientAuth->getRequest()->attributes->get('_controller')
        );
 
        // Verification http de la redirection.
        $this->assertSame(Response::HTTP_OK, $this->clientAuth->getResponse()->getStatusCode());

        // $this->assertSame(302, $this->client->getResponse()->getStatusCode());
 
        // Verification si c'est la bonne page.
        $this->assertContains('Bienvenue sur Symfony 4 !', $this->clientAuth->getResponse()->getContent());

    }

    public function testLogin()
    {
        
        // ./vendor/bin/simple-phpunit --filter=testLogin

        // $this->logInAuth();
    
        $clientAuth = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'khafid',
            'PHP_AUTH_PW'   => 'sio22',
        ));

        $crawler = $clientAuth->request('GET', '/', array(), array(), array(
            'PHP_AUTH_USER' => 'khafid',
            'PHP_AUTH_PW'   => 'sio22',
        ));

        // $this->logIn();

        // dump($this->logInFaster()); die();

        // Interrogation de la page de bienvenue
        // $crawler = $this->client->request('GET', '/');
 
        $this->assertEquals(
            'App\Controller\DiaryController::index',
            $clientAuth->getRequest()->attributes->get('_controller')
        );
 
        // Verification http de la redirection.
        // $this->assertSame(Response::HTTP_OK, $clientAuth->getResponse()->getStatusCode());

        $this->assertSame(302, $clientAuth->getResponse()->getStatusCode());
 
        // Verification si c'est la bonne page.
        $this->assertContains('Bienvenue sur Symfony 4 !', $clientAuth->getResponse()->getContent());

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


    // public function testAdmin()
    // {
    //     $this->logIn();

    //     // Interrogation de la page.
    //     $crawler = $this->client->request('GET', '/admin');
 
    //     $this->assertEquals(
    //         'CP\CoreBundle\Controller\DefaultController::guidesAction',
    //         $this->client->getRequest()->attributes->get('_controller')
    //     );
 
    //     // Verification http code 302 (Redirection auth).
    //     //$this->assertTrue(200 === $this->client->getResponse()->getStatusCode());
 
    //     $crawler = $this->client->request('GET', '/test/search');
    //     echo " - ".$this->client->getResponse()->getStatusCode();
 
    //     // Verification http code 302 (Redirection auth).
    //     $this->assertTrue(200 === $this->client->getResponse()->getStatusCode());
 
    //     // Verification si c'est la bonne page.
    //     $this->assertContains('Guide', $this->client->getResponse()->getContent());
 
 
    // }

    /**
     * Test du chargement et du contenu de la Homepage
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
            'Liste des rapports', 
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

        // dump($listPage->filter('h1')->first()->text());die;

        //Test si le titre principal est 'Liste de tous les rapports'
        $this->assertEquals('Liste de tous les rapports', $listPage->filter('h1')->first()->text());


        //Test 1 si aucun rapport n'est affiché
        // $this->assertEquals('Aucune entrée dans le journal pour l\'instant.', $listPage->filter('p')->first()->text());

        //Test 2 si aucun rapport n'est affiché
        // $this->assertEquals('Ajouter une nouvelle entrée', $listPage->filter('a:contains("Ajouter une nouvelle entrée")')->first()->text());
       

        //Test lien "Contact"
        $linkContact = $crawler->filter('a:contains("Contact")')->first()->link();

        //Simulation du clic et ouverture de la page correspondante
        $PageContact = $client->click($linkContact);

        //Test si le titre principal est 'Liste de tous les rapports'
        $this->assertEquals('Formulaire de contact', $PageContact->filter('h1')->first()->text());
        
        //Test lien "Liste des rapports"
        $link = $crawler->filter('a:contains("Contact")')->first()->link();

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
    public function testAddReportFromList()
    {
        // Commande: ./vendor/bin/simple-phpunit --filter=testAddReportFromList

        $client = static::createClient();

        $crawler = $client->request('GET', '/diary/list');

        $this->assertEquals(1, $crawler->filter('h1:contains("Liste de tous les rapports")')->count());

        $this->assertContains('Liste de tous les rapports', $client->getResponse()->getContent());

        //On select le form via le bouton 'Ajouter' : mon crawler représente le bouton
        $form = $crawler->selectButton('Ajouter une nouvelle entrée')->form();

        $addReport = $client->submit($form);

        //Test si le titre principal est 'Ajouter un repas'
        $this->assertEquals(1, $addReport->filter('h1:contains("Ajouter un repas")')->count());

        //On select le form via le bouton 'Ajouter' : mon crawler représente le bouton
        $form = $addReport->selectButton('Ajouter')->form();

        $form->setValues(array(
            'food[username]' => 'Jean',
            'food[entitled]' => 'Tarte aux fraises',
            'food[calories]' => 85962,
            )
        );

        $client->submit($form);

        $this->assertSame(302, $client->getResponse()->getStatusCode());

    }


    /**
     * Test la suppression d'un rapport depuis la page liste
     *
     * Aller sur la vue "Voir tous les rapports"
     * Cliquer sur le bouton "Supprimer"
     * Le rapport est supprimé
     * Vérifier que la réponse au client contient une notification de suppression
     * 
     */
    public function testDeleteReport()
    {
        // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testDeleteReport

        //On requête la page qui affiche le formulaire
        $client = static::createClient();

        $crawler = $client->request('GET', '/diary/list');

        $this->assertEquals(1, $crawler->filter('h1:contains("Liste de tous les rapports")')->count());

        //On select le form via le bouton 'Ajouter' : mon crawler représente le bouton
        $form = $crawler->selectButton('Supprimer')->form();

        $deleteReport = $client->submit($form);

        //Suivre la redirection vers le formulaire
        $deleteReport = $client->followRedirect(); 

        //Test soumission formulaire
        $this->assertRegexp('/L\'entrée a bien été?/', $deleteReport->filter('div.alert.alert-success')->first()->text());

    }


    /**
     * Test du formulaire de contact de food-diary
     * 
     */
    public function testContactForm()
    {
        // Commande de "test" : ./vendor/bin/simple-phpunit --filter=testContactForm

        $client = static::createClient();

        $crawler = $client->request('GET', '/diary/Contact');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Envoyer')->form();
        $crawler = $client->submit($form);

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

        //Test champs vides
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




                          //Test : Authentification
    
}
