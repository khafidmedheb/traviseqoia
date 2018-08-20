Feature: Register user
  In order to see if we can register a user
  As a website user
  I need to be able to create my account

  Scenario: See the register page
    Given I am on "/register"
    Then I should see "Log in" 
    And I fill in "Email" with "titi456@gmail.com"
    And I fill in "Username" with "titi"
    And I fill in "Password" with "titi123"
    And I fill in "Repeat password" with "titi123"
    And I press "Register"
    Then I should see "The user has been created successfully."
    And I should see "Logged in as titi"
    And I should see "Congrats titi, your account is now activated."