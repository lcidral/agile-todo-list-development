# TODO list

# API
> **Note:** All the sample request files are in the folder **`/docs/http_requests/`**.
## User Stories  
### 1) See the items of TO DO list
#### ACCEPTANCE CRITERIA:  
 - [x] The API must be developed using REST concepts and practices.
 - [x] The user must be able to get the list of all existing tasks.
 - [x] The user must be able to get the details of a task.
 - [x] In case there is no task, the API must return the following message: "Wow. You have nothing else to do. Enjoy the rest of your day!".  
#### GHERKIN
```gherkin
Feature: See the items of TO DO list
  In order to list all todo items
  As a guest user
  I need to see what tasks I need to work on

  Scenario: Get all items of TO DO list
    Given I have items in task table
    Then I should see an list of tasks

  Scenario: No tasks found in TODO list
    Given I not have items in task database table
    Then I should see "{{message['not_found']}}"
```
#### LIST OF REST RESOURCES
|Method  |Resource  |JSON Post Body |Http Request Example  | Additional info
|--|--|--|--|--|
|GET  |/tasks/               |  |[get_tasks.http](docs/http_requests/get_tasks.http)                    |
|GET  |/task/{UUID}          |  |[get_task_detail.http](docs/http_requests/get_task_detail.http)                | Update UUID param
|GET  |/task/uuid-not-found  |  |[get_task_not_found.http](docs/http_requests/get_task_not_found.http)  | 
    
### 2) Add a new item into my TO DO list
#### ACCEPTANCE CRITERIA
 - [x] The API must be developed using REST concepts and practices.
 - [x] The system must not allow empty tasks. If that happens, then the API must return the following message: "Bad move! Try removing the task instead of deleting its content.".  
 - [x] The system must set the date in which the item was created automatically.
 - [x] UUID must be automatically generated and it must be unique.
 - [x] The task Type must only allow "shopping" or "work". If another type is passed, then the API must return the following message: "The task type you provided is not supported. You can only use shopping or work.".  
#### GHERKIN
```gherkin
Feature: Add a new item into my TO DO list
  In order to send todo list JSON Params
  As a guest user
  I need to see a new item in database task table
  
  Scenario: Add empty task item
    Given I send a new post request with content task empty
    Then I should see message "{{message['empty']}}"

  Scenario: Set the date in which the item was created automatically
    Given I send a new valid post request task
    Then I see DATETIME column with actual date time

  Scenario: UUID must be automatically generated
    Given I send a new valid post request task
    Then I see UUID column automatically generated

  Scenario: Create new task type shopping
    Given I send a new task with o type shopping
    Then I see success in response

  Scenario: Create new task type work
    Given I send a new task with o type work
    Then I see success in response

  Scenario: Create new task with unknow type
    Given I send a new task with invalid task type
    Then I see message "{{message['invalid_task_type']}}"
```
#### LIST OF REST RESOURCES
|Method  |Resource  |JSON Post Body |Http Request Example  | Additional info
|--|--|--|--|--|
|POST  |/tasks/  |type           |[post_empty_task.http](docs/http_requests/post_empty_task.http)                        |
|POST  |/tasks/  |type, content  |[post_task_datetime.http](docs/http_requests/post_task_datetime.http)                  |
|POST  |/tasks/  |type, content  |[post_task_uuid.http](docs/http_requests/post_task_uuid.http)                          |
|POST  |/tasks/  |type, content  |[post_shopping_type_task.http](docs/http_requests/post_shopping_type_task.http)        |
|POST  |/tasks/  |type, content  |[post_work_type_task.http](docs/http_requests/post_work_type_task.http)                |
|POST  |/tasks/  |type, content  |[post_work_unknow_type_task.http](docs/http_requests/post_work_unknow_type_task.http)  |
  
## 3) Delete an existing task
#### ACCEPTANCE CRITERIA
 - [x] The API must be developed using REST concepts and practices.
 - [x] The user must be able to delete an existing task.  
 - [x] If the task isn't valid anymore, the API must return the following message: "Good news! The task you were trying to delete didn't even exist.".  
#### GHERKIN
```gherkin
Feature: Delete a task from my TO DO list
  In order to send DELETE request
  As a guest user
  I need discard the tasks that I will no longer need to do

  Scenario: Delete an existing task
    Given I send an existing UUID in TODO list
    Then I should see success in response

  Scenario: No task found in TODO list
    Given I not have items in task database table
    Then I should see "{{message['not_found']}}"

  Scenario: Task not exists
    Given I send GET request to tasks resource with an invalid UUID
    Then I should see "{{message['not_exists']}}"
```
#### LIST OF REST RESOURCES
|Method  |Resource  |JSON Post Body |Http Request Example  | Additional info
|--|--|--|--|--|
|DELETE  |/tasks/{UUID}           |type, content  |[delete_task.http](docs/http_requests/delete_task.http)                     | Update UUID param
|DELETE  |/tasks/uuid-not-exists  |type, content  |[delete_task_not_exist.http](docs/http_requests/delete_task_not_exist.http) |

## 4)  Edit the information of an existing task
### ACCEPTANCE CRITERIA
 - [x] The API must be developed using REST concepts and practices.
 - [x] The user must be able to edit the information of an existing task.
 - [x] If the task doesn't exist, then the API must return the following message: "Are you a hacker or something? The task you were trying to edit doesn't exist.".  
#### GHERKIN
```gherkin
Feature: Edit the information of an existing task
  In order to send REORDER request
  As a guest user
  I need to organize my work always deliver the mos valuable things first

  Scenario: Edit the information of an existing task
    Given I send PUT request with an valid UUID
    Then I should see "{{message['success']}}"

  Scenario: Edit the information of an non-existent task
    Given I send PUT request with an UUID
    Then I should see "{{message['success']}}"
```
#### LIST OF REST RESOURCES
|Method  |Resource  |JSON Post Body |Http Request Example  | Additional info
|-|--|--|--|--|
|PUT  |/tasks/{UUID}           |type, content  |[put_task.http](docs/http_requests/put_task.http)                      | Update UUID
|PUT  |/tasks/uuid-not-exists  |type, content  |[put_task_not_exist.http](docs/http_requests/put_task_not_exist.http)  | 

## 5) Prioritize the tasks of my TO DO list  
### ACCEPTANCE CRITERIA
 - [x] The API must be developed using REST concepts and practices.
 - [x] The user must be able to reorder the list based on his prioritization criteria.
 - [x] If the task shares the same priority of another existing task, the the system must be smart enough to reorder the entire list and prevent priority conflicts.  
#### GHERKIN
```gherkin
Feature: Prioritize the tasks of my TO DO list
  In order to send REORDER request
  As a guest user
  I need to organize my work always deliver the mos valuable things first

  Scenario: Update sort order item in my TODO list
    Given I send PATCH request with an UUID
    Then I should see "{{message['success']}}"

  Scenario: Update sort order item
    Given I send PATCH request with an UUID
    E I send sort_order value in post body request
    Then I should see "{{message['success']}}"

  Scenario: Prevent duplicate sort order
    Given I send PATCH request with an UUID
    E I send any sort_order value in post body request
    Then I dont see duplicate sort_order value in task table
```
|Method  |Resource  |Post Body |Http Request Example  | Additional info
|--|--|--|--|--|
|PATCH  |/tasks/reorder/{UUID}  |sort_order  |[patch_reorder_task.http](docs/http_requests/patch_reorder_task.http)  | Update UUID param
  
#### EXTRA INFORMATION  
##### Entity
```json 
{  
 "uuid": "", 
 "type": "", 
 "content": "", 
 "sort_order" : 0, 
 "done" : true|false, 
 "date_created": "" 
}
 ```  
  

# REFACTORING
> **Note:** Refactored files were moved to folder **`/src/`**.
## User Stories  
### 1) Improve the quality of a legacy code by refactoring  
#### ACCEPTANCE CRITERIA
 - [x] The signature of the methods, as well as their inputs and outputs must be kept intact. 
 - [x] The use of PSR-1 standard is required ("http://www.php-fig.org/psr/psr-1/").  
 - [x] The use of PSR-2 standard is required ("http://www.php-fig.org/psr/psr-2/"). 
 - [x] The use of PSR-4 standard is required ("http://www.php-fig.org/psr/psr-4/").  

#### GHERKIN
```gherkin
Feature: Improve the quality of a legacy code by refactoring
  In order to code refactory
  As a developer
  I need to use best pactices to improve the quality code of system

  Scenario: Use of PSR-1 standard is required
    Given I have the code in reposity
    Then I see PSR-1 standards applied in the code

  Scenario: Use of PSR-2 standard is required
    Given I have the code in reposity
    Then I see PSR-2 standards applied in the code

  Scenario: Use of PSR-4 standard is required
    Given I have the code in reposity
    Then I see PSR-4 standards applied in the code
```
#### EXTRA INFORMATION  
 * File 1) [composer.json](composer.json)
 * File 2) [src/routes.php](src/routes.php)
 * File 3) [src/Task.php](src/Task.php)
 * File 4) [src/CreditCard.php](src/CreditCard.php)
 * File 5) [src/CreditCardErrors.php](src/CreditCardErrors.php) 
 * File 6) [src/CreditCardTest.php](src/CreditCardTest.php)
> **Note:** Run PHPUnit tests
