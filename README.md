# Snowdog PHP Recruitment test

Test scenario is cache warming application.
When website uses full page caching (like Varnish Cache) there may be requirement to periodically warm cache contents.
This consists of purging cache contents for given address and visiting given address.
Following application allows for multiple users to define multiple websites and for those websites define multiple URLs to visit.

Application uses:
* [composer](http://getcomposer.org)
* [PDO](http://php.net/manual/en/book.pdo.php) for MySql access
* [Silly](http://mnapoli.fr/silly/) for CLI commands
* [FastRoute](https://github.com/nikic/FastRoute) for routing
* [PHP-DI](http://php-di.org/) as dependency injection container

Following diagram shows basic database scheme
![Database Scheme](doc/db.png)


## Task 1

Fork this git repository.
_Make sure to commit Your work after every completed task._
> Hint: make sure Your solutions are private, do NOT make pull requests against this repository to submit Your solutions

Install and configure application by running following command
`php console.php migrate_db`

You can run PHP build-in server by running following command
`php -S 0.0.0.0:8000 -t web/`

The web application is running at http://localhost:8000.

Now create `.gitignore` file appropriate for Your development environment.

## Task 2

As You may have noticed console command `php console.php warm 3` is failing because it cannot access legacy library located in `lib` directory.
Fix this problem.

## Task 3

Modify application so that we can see and track time of last page visit.
This will require database modification, changes to cache warming process and changes to pages views.
> Hint: for introducing database changes see `\Snowdog\DevTest\Command\MigrateCommand`

## Task 4

On homepage for logged in users add following information:
* Total number of pages associated with this user
* Least recently visited page
* Most recently visited page

## Task 5

Allow users to define multiple caching servers.
Each caching server has it's own unique IP address and can cache multiple websites.
You can assume that different users do not share caching servers.
This will require database modification, changes to cache warming process and changes on frontend.
Use partial solution available in branch `task/five`.
Use AJAX requests for saving caching server - website association.

## Task 6

Create new empty git repository.

In newly created repository create new application component that allows adding new websites and pages by importing [sitemap file](http://www.sitemaps.org/).
This functionality should be accessible via both command line and frontend.

## Task 7

As You may have noticed pages that require logged in user are visible to users, and those that make sense only for not logged in users (like login or registration forms) are visible to logged in users.
Introduce modification that will fix this problem (show login form to not logged in users on pages that require user context and show 403 message on login and registration forms when user is logged in).
