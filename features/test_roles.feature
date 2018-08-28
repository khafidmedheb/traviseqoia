Feature: Test the roles
    In order to see the current status of my application
    As a user or an administrative user
    I need to be able to be able to connect with each role

    #Background:
        # Given there are following users:
        #     | username  | email               | password | enabled |
        #     | testuser  | testuser@gmail.com  | titi     | true    |
        #     | testadmin | testadmin@gmail.com | titi     | true    |

    Background:
        Given I am logged in as admin

    # vendor/bin/behat --name="Testing the login as user"
    

    # Scénario simplifié d'un utilisateur déjà authentifié
    # vendor/bin/behat --name="Testing the role user on user test"
    # Scenario: Testing the role user on user test
    #     Given I am authenticated as User
    #     When I am on "/user/test/"
    #     Then I should see "Bienvenue sur la page test login utilisateur !"
    #     And I should see "Hello testuser, tu es bien connecté en tant qu'utilisateur !"

    # vendor/bin/behat --name="Testing the role user on admin test"
    # Scenario: Testing the role user on admin test
    #     Given I am authenticated as User
    #     And I am on "/admin/test"
    #     # Page d'erreur Symfony - erreur 403
    #     Then I should see "Access denied."
    #     And I should see "HTTP 403 Forbidden"

    # vendor/bin/behat --name="I am admin and i see my test page"
    # @smartStep
    Scenario: I am admin and i see my test page
        Given I am on "/admin/test/"
        # Then I should see "Bienvenue sur Symfony 4 !"
        # And I should see "Built With Symfony 4.1.3 Version MIT License"
        # When I am on "/admin/test"
        Then I should see "Admin Dashboard"
        And I should see "Hello testadmin, tu es bien connecté en tant qu'utilisateur... !"
        And I should see "...promu administrateur : tu peux donc voir cette phrase !."

    # Scénario simplifié d'un utilisateur déjà authentifié
        # vendor/bin/behat --name="Testing the role user"
        # Scenario: Testing the role user
        # Given I am authenticated as "testuser"
        # And I am on "/user/test"
        # Then I should see "Bienvenue sur la page test login utilisateur !"
        # And I should see "Hello testuser, tu es bien connecté en tant qu'utilisateur !"