# vendor/bin/behat features/naviguer.feature
Feature: Create a meal
  In order to use application functionality          
  As a user
  I need to be able to browse into my website and fill in the meal form

@api
# vendor/bin/behat --name="Clear cache"
Scenario: Clear cache
    Given the cache has been cleared
    When I am on the homepage
    Then I should get a "200" HTTP response

# vendor/bin/behat --name="Log in to the site"
Scenario: Log in to the site
    # User is on the login page
    Given I am on "/login"
    And I should see "Log in"
    And I should see "Username" 
    And I should see "Password" 
    And I should see "Remember me" 
    When I fill in the following:
        | Username | testname |
        | Password | titi     |
    And I check "Remember me"
    And I press "Log in"
    Then I should be on "/"
    And I should see "Bienvenue sur Symfony 4 !"
    And I should see "Built With Symfony 4.1.3 Version MIT License"
    When I move backward one page
    Then I should be on "/login"
    # And I should see "Logged in as testname | Log out"
    # # Log out : on revient sur la page de log in par défaut
    # When I follow "Log out"
    # Then I should be on "/login"
    # And I should see "Log in"
    # And I should not see "Logged in as testname"
    
# vendor/bin/behat --list-scenarios "Log in to the site, Log out of the site"
# vendor/bin/behat --name="Log out of the site"
Scenario: Log out of the site
    Given I am on "/login"
    And I should see "Logged in as testname | Log out"
    When I follow "Log out"
    Then I should be on "/login"
    And I should not see "Logged in as testname"
    
# vendor/bin/behat --name="On the homepage"
Scenario: On the homepage 
    # User is on the Homepage
    Given I am on "/diary"
    Then I should see "Bienvenue sur FoodDiary !"
    And I should see "Titre h2"
    And I should see "Titre h3"
    And I should see "Titre h6"
    And I should see "Vous devez vous connecter pour pouvoir accéder à votre journal."
    And I should see "Copyright © Food Diary 2018"
    And I follow "Ajouter un nouveau rapport"
    Then I should be on "diary/add-new-record"
    
# vendor/bin/behat --name="On the meal form"
Scenario: On the meal form 
    # Page du formulaire
    Given I am on "diary/add-new-record"
    Then I should see "Ajouter un repas"
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

# vendor/bin/behat --name="Back to the homepage"
Scenario: Back to the homepage
    # Je reviens sur la Homepage
    When I follow "Food diary"
    Then I should be on "/diary"
    And I should see "Bienvenue sur FoodDiary !"
    And I should see "Titre h2"
    And I should see "Titre h3"
    And I should see "Titre h6"
    And I should see "Vous devez vous connecter pour pouvoir accéder à votre journal."
    And I should see "Copyright © Food Diary 2018"

# vendor/bin/behat --name="Make a meal"
Scenario: Make a meal
    # Click lien "Voir tous les rapports" 
    When I follow "Voir tous les rapports"
    Then I should be on "diary/list"
    And I should see "Liste de tous les rapports"
    And I should see "Ajouté le"
    And I should see "Supprimer"
    And I should see "Copyright © Food Diary 2018"
    Then I press "Supprimer"  
    And I should see "L'entrée a bien été supprimée du journal."
    And I should see "Liste de tous les rapports"
    # And I should see "Aucune entrée dans le journal pour l'instant."
    And I should see "Copyright © Food Diary 2018"
    And I should see "Ajouter une nouvelle entrée" 
    # And I fill in "Ton nom ?" with "toto"
    # And I fill in "Nom du plat" with "Tajine"
    # And I fill in "Calories" with " 1000" 
    When I fill in the following:
        | Ton nom ?   | testnom |
        | Nom du plat | testrepas |
        | Calories    | 2000 |
    And I press "Ajouter une nouvelle entrée"
    Then I should be on "diary/add-new-record"
            # And I should see "Une nouvelle entrée dans votre journal a bien été ajoutée."
    And I should see "Ajouter un repas"
    And I should see "Ajouter"

# vendor/bin/behat --name="Work with Ajax"   
Scenario: Work with Ajax
    # Click lien "Ajax"
    When I follow "Ajax"
    Then I should be on "/diary/ajax_request"
    And I should see "Liste de tous les rapports"
    And I should see "Formulaire test Ajax"
    And I should see "Email"
    And I should see "Password"
    And I should see "Address"
    And I should see "Address 2"
    And I should see "City"
    And I should see "State"
    And I should see "Zip"
    And I should see "Check me out"
            # And the "Check me out" checkbox should not be checked
    # voir un toggle ???
    # voir un bouton Sign in ??
    And I should see "Sign in"
    And I should see "Bouton test Ajax"
    And I should see "Here comes the result"
    When I press "Click me !"
            # Then I should see "Vous avez cliqué..."
            # And I should see "Liste déroulante test Ajax !"

