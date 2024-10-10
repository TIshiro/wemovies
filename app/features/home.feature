Feature: Home Page
  As a user
  I want to visit the home page
  So that I can see the home page content

  Scenario: Visiting the home page
    Given I am on the homepage
    Then the response status code should be 200
