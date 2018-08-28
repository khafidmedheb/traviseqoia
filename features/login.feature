Feature: Login
  In order to see if the login page works
  As a website user
  I need to be able to see the login page

  Scenario: See the login page
    Given I am on "/login"
    Then I should see "Log in" 
    And I should see "Username" 
    And I should see "Password" 
    And I should see "Remember me"
    And I press "Log in"

  # @smartstep
  # Scenario: I am logged as user 
  #   # Given I am on the login page
  #   Given I am on "/login"
  #   When I fill in the following:
  #       | username | testuser |
  #       | password | titi |
  #   And I press "Log in"
  #   When I am on "/user/test"
  #   Then I should not see "Bad credentials"
    # Then I should see "Bienvenue sur la page test login utilisateur !"
    # And I should see "Hello testuser, tu es bien connecté en tant qu'utilisateur !"

  # vendor/bin/behat --name="I am logged in as admin"
  # @smartstep
  # Scenario: I am logged in as "testadmin"
  #   Given I am on "/login"
  #   When I fill in the following:
  #       | Username | testadmin |
  #       | Password | titi |
  #   And I press "Log in"
  #   Then I should not see "Bad credentials"
    # When I am on "/admin/test"
    # Then I should see "Admin Dashboard"
    # And I should see "Hello testadmin, tu es bien connecté en tant qu'utilisateur... !"
    # And I should see "...promu administrateur : tu peux donc voir cette phrase !."