Feature: Test the role of user
    In order to see the current status of my application
    As a user
    I need to be able to see my proper pages

    Background:
        Given I am logged in as user

    # user doit pouvoir se logguer sur sa page de test
    # vendor/bin/behat --name="I am a user and i see my test page"
    Scenario: I am a user and i see my test page
        Given I am logged in as user
        When I am on "/user/test/"
        Then I should see "Bienvenue sur la page test login utilisateur !"
        And I should see "Hello testuser, tu es bien connecté en tant qu'utilisateur !"

    # ... mais pas sur la page de test admin
    # vendor/bin/behat --name="I am a user and i should not see admin test"
    Scenario: I am a user and i should not see admin test
        Given I am logged in as user
        And I am on "/admin/test"
        # Page d'erreur Symfony - erreur 403
        Then I should see "Access denied."
        And I should see "HTTP 403 Forbidden"
