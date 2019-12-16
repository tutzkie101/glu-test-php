# Simple Web-api Queue System

> ### A simple queue system that accepts tasks and is fulfilled by processors. It is built on top of the laravel framework.


----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)


Clone the repository

    git clone https://github.com/tutzkie101/glu-php-test.git

Switch to the repo folder

    cd glu-php-test

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/tutzkie101/glu-php-test.git
    cd glu-php-test
    composer install
    cp .env.example .env
    php artisan key:generate 
    
**Make sure you set the correct database connection information before running the migrations. For this exercise, use sqlite as the database.**

    php artisan migrate
    php artisan serve

# Code overview


## Folders

- `app/Models` - Contains all the Eloquent models
- `app/Http/Controllers/Processor` - Contains the Processor api controllers
- `app/Http/Controllers/Task` - Contains the Tasks api controllers
- `config` - Contains all the application configuration files
- `database/migrations` - Contains all the database migrations
- `routes` - Contains all the api routes defined in web.php file

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The Tasks api can now be accessed at

| **Method** 	| **uri**              	| **package**            	| **Content**   |
|----------	|------------------	|------------------	|-------------------|
| GET      	| /tasks/nextPriority     	| Null 	|     	|       |
| GET      	| /tasks/get     	| Null 	|     	|       |
| GET      	| /tasks/get/{task_id}     	| Null 	|     	|       |
| POST      	| /tasks/store     	| application/json 	|[ { "submitters_id": int, "priority": int, "package": { "task": string, "data": object } },... ]      	|       |                    
       |


The Process api can now be accessed at

| **Method** 	| **uri**              	| **package**            	| **Content**   |
|----------	|------------------	|------------------	|-------------------|
| GET      	| /processor/get/{processor_id}     	| Null 	|     	|       |
| GET      	| /processor/average     	| Null 	|     	|       |
| GET      	| /processor/get     	| Null 	|     	|       |
| POST      	| /processor/proc    	| application/json 	|[ { "name": string},... ]      	|       |                    
       |
       
Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|     	|


