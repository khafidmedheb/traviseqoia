Feature: Authentication
  In order to gain access to the site management area
  As an admin
  I need to be able to login and logout

  Scenario: Logging in
    Given I am on "/login"
    When I follow "Log in" 
    And I fill in "Username" with "toto"
    And I fill in "Password" with "toto123"
    And I press "Log in"
    Then I should see "Bienvenue sur Symfony 4 !"

  Scenario: Not logging in
    Given I am on "/login"
    When I follow "Log in" 
    And I fill in "Username" with "tata"
    And I fill in "Password" with "tata123"
    And I press "Log in"
    Then I should see "Invalid credentials."

