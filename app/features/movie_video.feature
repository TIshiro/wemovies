Feature: Get movie video
  As a user
  I want to get the video information of a movie
  So that I can see the details of the requested movie video

  Scenario: Getting movie video information
    Given I am on "/movie/519182/video"
    Then the response status code should be 200
    And the response should be a valid JSON
    And the JSON response should have the following keys:
      | id          |
      | name        |
      | key         |
