Feature: Register user
  In order to see if we can register a user
  As a website user
  I need to be able to create my account

  Scenario: Create a new user
    Given I am on "/register"
    Then I should see "Log in" 
    And I fill in "Email" with "user3000@gmail.com"
    And I fill in "Username" with "user3000"
    And I fill in "Password" with "user3000"
    And I fill in "Repeat password" with "user3000"
    And I press "Register"
    Then I should see "The user has been created successfully."
    And I should see "Logged in as user3000"
    And I should see "Congrats user3000, your account is now activated."