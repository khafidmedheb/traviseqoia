Feature: Sign in to the website
    In order to access the administrative interface
    As a visitor
    I need to be able to log in to the website

    Background:
        Given there are following users:
            | username | email          | password | enabled |
            | testname | test@gmail.com | titi     | true    |

    # vendor/bin/behat --name="Log in with username and password"
    Scenario: Log in with username and password
        Given I am on "/admin/login"
        When I fill in the following:
            | username | testname |
            | password | titi |
        And I press "Log in"
        Then I should be on "/admin"
        And I should see "Logout"

    Scenario: Log in with bad credentials
        Given I am on "/admin/login"
        When I fill in the following:
            | username | kmbappe |
            | password | toto123 |
        And I press "Log in"
        Then I should be on "/admin/login"
        And I should see "Invalid username or password"