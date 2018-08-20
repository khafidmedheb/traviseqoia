Feature: Homepage
  In order to see if the home page works
  As a website user
  I need to be able to see the home page

  Scenario: See the home page
    Given I am on "/diary"
    Then I should see "Bienvenue sur FoodDiary !"
    And I should see "Titre h2"
    And I should see "Titre h3"
    And I should see "Titre h6"
    And I should see "Vous devez vous connecter pour pouvoir accéder à votre journal."
    And I should see "Copyright © Food Diary 2018"