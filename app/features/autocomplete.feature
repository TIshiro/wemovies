Feature: Autocomplete
  As a user
  I want to get autocomplete suggestions
  So that I can see the autocomplete results based on my query

  Scenario: Getting autocomplete suggestions
    Given I am on "/autocomplete?q=Alita"
    Then the response status code should be 200
    And the response should be a valid JSON
    And the JSON response should contain "Alita: Battle Angel"