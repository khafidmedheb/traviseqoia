Feature: Login
  In order to see if the login page works
  As a website user
  I need to be able to see the login page

  Scenario: See the login page
    Given I am on "/login"
    Then I should see "Log in" 
    And I should see "Username" 
    And I should see "Password" 
    And I should see "Remember me"
    And I press "Log in"
