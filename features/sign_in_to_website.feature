Feature: Sign in to the website
    In order to access the home page area
    As a visitor
    I need to be able to log in to the website

    # Background:
    #     Given there are following users:
    #         | username | email          | password | enabled |
    #         | toto     | toto@gmail.com | toto123  | true    |

    Scenario: Log in with username and password
        Given I am on "/login"
        When I fill in the following:
            | username | testname |
            | password | toto |
        And I press "Log in"
        Then I should be on "/"
        And I should see "Welcome to Symfony 4.1.3"

    Scenario: Log in with bad credentials
        Given I am on "/login"
        When I fill in the following:
            | username | kmbappe |
            | password | toto123 |
        And I press "Log in"
        Then I should be on "/login"
        And I should see "Invalid credentials."