# Library Storage System

This project implements a Library Storage System, providing functionalities for managing books and authors.\
The system is designed to handle complex tasks related to book management in a library.
## Pre Knowledge
We have 4 different files : 
- books.json and books.csv care storage of our books
- authors.json is list of authors
- command.json is your specified commandline. 
- The publishing date you return to user should be in format of time stamp.
- You are free to choose your own request / response cycle, but don't confuse yourself with this ,/ it can be decent to implement a merely simple cli-app
- Your deadline for the project is until end of the day. 


### Command.json
This file has two general keys : 1 - command_name  2 - parameters . 
You are just restricted in two keys. But for values you  are free to design your own system .
## Tasks

### Task 1: List of All Books

- Implement a paginated, filterable, and sortable list of all registered books.
- Allow users to choose the number of items per page and filter books by author.
- Sorting should be based of publish date

### Task 2: Getting a Specific Book

- Get a specific book based on its Isbn or return a not found message . 

### Task 3: Adding a New Book

- Be aware the ISBN format should be ISBN-13.
- Support batch additions by allowing users to upload a CSV or JSON file with multiple new books.

### Task 4: Deleting a Specific Book

- Implement a soft-delete mechanism instead of permanent deletion.
- Allow books to be marked as deleted but still accessible for historical purposes.
- it should be based on deleting 

### Task 5 : Update existed Source

- Update multiple items in your resources 
- you should be able to update one or more resources in one request.

