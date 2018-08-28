Feature: Test the role of admin
    In order to see the current status of my application
    As an administrator
    I need to be able to see my proper pages

    Background:
        Given I am logged in as admin

    # vendor/bin/behat --name="I am admin and i see my test page"
    Scenario: I am admin and i see my test page
        Given I am on "/admin/test/"
        Then I should see "Admin Dashboard"
        And I should see "Hello testadmin, tu es bien connecté en tant qu'utilisateur... !"
        And I should see "...promu administrateur : tu peux donc voir cette phrase !."

    # admin doit pouvoir se logguer sur sa page user test
    # vendor/bin/behat --name="I am an admin and i see test user page"
    Scenario: I am an admin and i see test user page
        # Given I am logged in as admin
        When I am on "/user/test/"
        Then I should see "Bienvenue sur la page test login utilisateur !"
        And I should see "Hello testadmin, tu es bien connecté en tant qu'utilisateur !"
        And I should see "Tu es admin, tous les utilisateurs ont accès à cette page, mais seul toi peut voir cette phrase."