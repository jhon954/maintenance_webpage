# Maintenance Management Web Application

## Project Description
This project is a web application for registering and tracking the maintenance activities within a company's maintenance department. The application has been built using PHP, HTML5, CSS, JavaScript, and Bootstrap.

## Features
- **QR Code Generation**: Generates QR codes that can be scanned to direct users to a form for creating a task for a specific machine.
- **Task Feed**: Tasks appear in the feed of maintenance collaborators who access the page via login. Administrators can assign tasks, and collaborators execute them.
- **Task Completion**: Once tasks are completed, a conclusion form is filled out, and the task is recorded as completed and stored in the machine's history.
- **Machine and Area Management**: View, edit, and create areas and machines. Add or edit collaborator status, all based on user roles (collaborator or administrator).
- **Calendar Integration**: Implemented a calendar using JavaScript to visualize tasks and create them on specific dates, aiding in the planning of preventive maintenance schedules.

## Repository Contents
- **PHP Files**: Backend logic for handling form submissions, task management, and user authentication.
- **HTML5/CSS/JavaScript**: Frontend components for displaying the web pages, forms, and calendar.
- **Bootstrap**: For responsive design and styling.
- **QR Code Library**: Used for generating QR codes.

## System Requirements
- PHP installed on the server.
- A web server such as Apache or Nginx.
- MySQL or any other database supported by PHP.
- Modern web browser for accessing the web application.

## Setup Instructions
1. Clone this repository to your local system.
2. Set up your web server and ensure PHP is installed.
3. Import the database schema provided in the repository.
4. Configure the database connection in the PHP files.
5. Launch the web application by navigating to the appropriate URL in your web browser.

## Credits
This project was developed by Jhon Fredy Moreno for his internship.

## Migration to Java and Spring Boot
Please note that this project in PHP is left at this point as I have started migrating to Java to utilize the Spring Boot framework. Future development and improvements will be continued in the new Java-based version of the application.
