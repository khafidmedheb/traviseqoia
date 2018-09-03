Feature: Register user
  In order to see if we can register a user
  As a website user
  I need to be able to create my account

  # vendor/bin/behat --name="Create a new user"
  Scenario: Create a new user
    Given I am on "/register"
    Then I should see "Log in" 
    And I fill in "Email" with "TEST123@gmail.com"
    And I fill in "Username" with "test123"
    And I fill in "Password" with "test123"
    And I fill in "Repeat password" with "test123"
    And I press "Register"
    Then I should see "The user has been created successfully."
    And I should see "Logged in as test123"
    And I should see "Congrats test123, your account is now activated."