@block @block_activitynavigation
Feature: Block activitynavigation
  In order to overview activitynavigation in a course
  As a manager
  I can add activities block in a course frontpage

  Scenario: Add activities block in a course
    Given the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "Activitynavigation" exist:
      | activity   | name                   | intro                         | course | idnumber    |
      | assign     | Test assignment name   | Test assignment description   | C1     | assign1     |
      | book       | Test book name         | Test book description         | C1     | book1       |
      | chat       | Test chat name         | Test chat description         | C1     | chat1       |
      | choice     | Test choice name       | Test choice description       | C1     | choice1     |

    When I log in as "admin"
    And I am on "Course 1" course homepage with editing mode on
    And I add the "Activitynavigation" block
    And I click on "Acticity" "link" with cmid,activityname,created date,completion status in the "Activitynavigation" "block"
    Then I should see respective "Activity Page"
    
