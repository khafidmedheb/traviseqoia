Feature: User exist
  In order to see if we can register a user
  As a website user
  I need to be able to see if email and username already exist

  Scenario: See if email and usermame already exist
    Given I am on "/register"
    Then I should see "Log in" 
    And I fill in "Email" with "userfix11@gmail.com"
    And I fill in "Username" with "user11"
    And I fill in "Password" with "titi"
    And I fill in "Repeat password" with "titi"
    And I press "Register"
    Then I should see "The email is already used."
    And I should see "The username is already used."