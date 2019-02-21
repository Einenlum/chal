Feature:
    In order to propose my friends to go out
    As a user
    I first want to create an event

    Scenario: I create an event
        When I create an event for an existing place
        Then I should get the confirmation that an event was created

    Scenario: I get an error when trying to create an invalid with an non existing place
        When I try to create an event with a non existing place
        Then I should get a not found error

    Scenario: I get the details of an event
        When I ask for the details of an existing event
        Then I should get the details of this event, including its posts
