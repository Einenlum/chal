Feature:
    In order to be able to use the app and get events
    As a user
    I first want to create a place

    Scenario: I create a place
        When I create a place with valid information
        Then I should get the confirmation that a place was created

    Scenario: I cannot create a place with invalid information
        When I try to create a place with an invalid payload
        Then I should get an error response
