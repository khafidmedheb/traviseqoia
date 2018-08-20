Feature: Index
  In order to see if the index page works
  As a website user
  I need to be able to see the index page

  Scenario: See the index page
    Given I am on "/"
    Then I should see "Bienvenue sur Symfony 4 !"