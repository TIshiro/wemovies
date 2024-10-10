Feature: Search movie
  As a user
  I want to search for movies
  So that I can see the search results

  Scenario: Searching for a movie
    Given I am on "/search?q=Inception"
    Then the response status code should be 200
    And the response should contain "Inception"