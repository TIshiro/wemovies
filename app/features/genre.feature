Feature: Get movies by genre
  To get the list of movies by genre
  As a user
  I want to visit the genre movies page

  Scenario: Visiting the movies page by genre
    Given I am on "/genre/28/movies"
    Then the response status code should be 200
    And I should see "We Movies: Action"
