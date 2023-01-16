@local @local_newsforumsubscribe
Feature: New users are automatically subscribed to main news fora

  @javascript
  Scenario: Latest course announcements are displayed and can be configured
    Given the following "users" exist:
      | username | firstname | lastname | email |
      | teacher1 | Teacher | 1 | teacher1@example.com |
      | student1 | Student | 1 | student1@example.com |
    And I log in as "admin"
    And I am on site homepage
    And I turn editing mode on
    And I add the "Latest announcements" block
    And I follow "Add a new topic"
    And I set the following fields to these values:
      | Subject | Hello  |
      | Message | Moodle |
    And I press "Post to forum"
    And I log out
    When I log in as "student1"
    And I am on site homepage
    And I follow "Older topics"
    Then I should not see "Subscribe to this forum"
    And I log out
    And I log in as "admin"
    And I navigate to "Users > Accounts > Add a new user" in site administration
    And I set the following fields to these values:
      | Username                        | testmultiemailuser1             |
      | Choose an authentication method | Manual accounts                 |
      | New password                    | test@User1                      |
      | First name                      | Test                            |
      | Last name                       | Multi1                          |
      | Email address                   | testmultiemailuser@example.com  |
    And I press "Create user"
    And I am on site homepage
    And I trigger cron
    And I am on site homepage
    And I log out
    When I log in as "testmultiemailuser1"
    And I am on site homepage
    And I follow "Older topics"
    Then I should not see "Subscribe to this forum"
