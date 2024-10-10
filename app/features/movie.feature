Feature: Autocomplete
  As a user
  I want to get movie details
  So that I can see the movie information's

  Scenario: Getting movie information's
    Given I am on "/movie/519182"
    Then the response status code should be 200
    And the response should be a valid JSON
    And the JSON response should have the following keys:
      | title       |
      | id          |
      | poster_path |
      | vote_average|
      | vote_count  |