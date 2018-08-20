Feature: Register
  In order to see if the register page works
  As a website user
  I need to be able to see the register page

  Scenario: See the register page
    Given I am on "/register"
    Then I should see "Log in" 
    And I should see "Email" 
    And I should see "Username" 
    And I should see "Password"
    And I should see "Repeat password"
    And I press "Register"
    