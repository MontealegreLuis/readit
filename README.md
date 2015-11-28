# ReadIt

[![Build Status](https://travis-ci.org/MontealegreLuis/readit.svg?branch=master)](https://travis-ci.org/MontealegreLuis/readit)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b412e223-6012-472f-ad54-ba81fe85eca4/mini.png)](https://insight.sensiolabs.com/projects/b412e223-6012-472f-ad54-ba81fe85eca4)

This is a lightweight clone of Reddit written in Laravel 5. It only has the
following features:

* User registration.
* User authentication.
* Registered users are called "Readitors" and they are allowed to post links to
  the site.
* All users are allowed to see all the links posted by all readitors.
* Only readitors are allowed to upvote and downvote links.
* Readitors can toggle their votes on links at any moment.
* Readitors can also cancel their votes at any moment.
* Links are ranked by votes, most voted links appear at the top.
* Links decrease their rank as time goes by, in order to allow new links to be
  at the top.
* Every 5 minutes a link decay its rank by one point. A day has `1440` minutes,
  then any link loose `288` points daily (`1440/5`). If a link was posted
  yesterday, and it has `300` points at this moment, its current rank would be
  `12` (`300 - 288`).

## Setup

In order to run this application locally, you'll need PHP 5.6, MySQL 5.6, and a
global installation of Composer.

1. Create your `.env` file, and edit it with your database development values.

    ```bash
    $ cp .env.example .env
    ```
2. Install the application.

    ```bash
    $ source .env
    $ make install RUSER="root" RPSWD="root" HOST=$DB_HOST DB=$DB_DATABASE USER=DB_USERNAME PSWD=DB_PASSWORD
    ```
    Where the values of `RUSER` and `RPSWD` are the credentials of a user with
    permissions to create databases and users.
3. Run the application

    ```bash
    $ php artisan serve
    ```
4. Browse to [http://localhost:8000/][1]

## Tests

Features are described using phpspec and there are some integration tests with
PHPUnit.

```bash
$ bin/phpspec run
$ bin/phpunit --testdox
```

### TODOs

There is room for improvement. This is my first Laravel application, so bear
with me.

* Ajax calls to vote a link should be sent through post.
* Javascript code needs to be decoupled and tested.
* CSS and Javascript assets should be managed with Gulp and Elixir.
* There should be some more tests and specs.
* There's no code for the case where a guest user tries to vote for a link.
* Password management is not configured.
* There's no captcha to post a links.
* Subreadits

Those are the ones I can identify now.

[1]: http://localhost:8000
