Feature: Testing the AppController

    Scenario: Visiting the homepage
        Given I visit "/"
        Then the response status code should be 200
        And I should see the text "We movies"

    Scenario: Visiting genre action
        Given I visit "/genre/28/movies"
        Then the response status code should be 200
