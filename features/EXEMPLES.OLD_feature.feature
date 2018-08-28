Feature: Create a meal
  In order to gain access to the form area for meal
  As a user
  I need to be able to fill the meal form

# vendor/bin/behat --name="Fill in data and submit meal registration form"
Scenario: Fill in data and submit meal registration form
    # User is on the Homepage
    Given I am on "/diary"
    Then I should see "Bienvenue sur FoodDiary !"
    And I should see "Titre h2"
    And I should see "Titre h3"
    And I should see "Titre h6"
    And I should see "Vous devez vous connecter pour pouvoir accéder à votre journal."
    And I should see "Copyright © Food Diary 2018"
    And I follow "Ajouter un nouveau rapport"
    # Page du formulaire
    Then I should be on "diary/add-new-record"
    And I should see "Ajouter un repas"
    And I should see "Ton nom ?"
    And I should see "Nom du plat"
    And I should see "Calories"
    And I fill in "Ton nom ?" with "toto"
    And I fill in "Nom du plat" with "Tajine"
    And I fill in "Calories" with " 1000"
    And I press "Ajouter"
    # Validation du formulaire
    Then I should be on "diary/add-new-record"
    And I should see "Une nouvelle entrée dans votre journal a bien été ajoutée."