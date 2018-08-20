Feature: Gotocontact
  In order to contact the admin
  As a website user
  I need to be able to go to the contact page area

  Scenario: Logging in
    Given I am logged in as "username" toto
    And I am on "/diary"
    And I follow "Contact"
    Then I should see "Formulaire de contact"