## About Assignment
### Purpose
This assignment that was built for [StuDocU](https://www.studocu.com/) is part of their recruitment process.

### Description
This code is creating an interactive menu for learning and practicing questions through the **laravel 9** console.
The user can either start fresh or continue his/her previous progress. 
There is a tracking code which represents the user and with this tracking code user can continue his/her practice any time. 
User's created questions and answers will be available for all users.

### Entities
- Flashcard Model
- TrackingCode Model

### Technologies and concepts

- Laravel 9
- Docker by Laravel Sail
- PHP 8.1
- Mysql
- Repository Design Pattern
- Solid Principles
- DRY

### How To Build
- To clone the project run `git clone git@github.com:sezarsaman/studocu.git`
- `cd studocu`
- To build by docker run `docker run --rm -v $(pwd):/opt -w /opt laravelsail/php81-composer:latest composer install`
- To give Permissions run `sudo chown -R $USER: .`
- To make the .env file run `cp .env.example .env`
- Set proper mysql variables and don't forget to change DB_HOST variable. It should be `DB_HOST=mysql`
- To open the bash run `vendor/bin/sail bash`
- To generate the key run `php artisan key:generate`
- To migrate and seed the DB run `php artisan migrate:fresh --seed`
- You should see laravel home by visiting `http://localhost` in the browser now
- You should see the interactive panel by running `php artisan flashcard:interactive`


### How to use
- Run `php artisan flashcard:interactive` in the vendor/bin/sail bash
- Follow the instruction in the menu
- Create a flashcard
- List all flashcards
- Practice
- Reset
- See the stats
