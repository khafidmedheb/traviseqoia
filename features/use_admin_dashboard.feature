Feature: Use the admin dashboard
    In order to see the current status of my application
    As an administrative user
    I need to be able to be able to use the admin dashboard

    Background:
        Given there are following users:
            | username | email          | password | enabled |
            | testname | test@gmail.com | titi     | true    |

    # vendor/bin/behat --name="Displaying the dashboard overview"
    Scenario: Displaying the dashboard overview
        Given I am on "/admin/login"
        When I fill in the following:
            | username | testname |
            | password | titi |
        And I press "Log in"
        Then I should be on "/admin/"
        And I should see "Admin dashboard"

    # Scénario simplifié d'un utilisateur déjà authentifié
    # vendor/bin/behat --name="Displaying the dashboard overview faster"
    Scenario: Displaying the dashboard overview faster
    Given I am authenticated as "testname"
    And I am on "/admin/"
    Then I should see "Admin dashboard"