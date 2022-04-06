# Sf-ecommerce

Well hi there! This repository holds the code and scripts
for an e-commerce website made using [Symfony 5](https://symfony.com/releases/5.0).

## Setup

To get it working, download the source code, or clone the repo to your local machine and follow these steps:

### Download Composer dependencies

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:

```bash
composer install
```

You may alternatively need to run `php composer.phar install`, depending
on how you installed Composer.

### Database Setup

First, you need to update the `DATABASE_URL` environment variable in
`.env` or `.env.local` before running the commands below.

Next, build the database and execute the migrations with:

```bash
# "symfony console" is equivalent to "bin/console"
# but it's aware of your database container
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
```

> I didn't use any fixtures to fill the DB. I may do that later, so you can experiment the website right away.

### Start the Symfony web server

You can use Nginx or Apache, but Symfony's local web server
works even better.

To install the Symfony local web server, follow
"Downloading the Symfony client" instructions found
here: <https://symfony.com/download> - you only need to do this
once on your system.

Then, to start the web server, open a terminal, move into the
project, and run:

```bash
symfony serve
```

(If this is your first time using this command, you may see an
error that you need to run `symfony server:ca:install` first).

Now check out the site at `https://localhost:8000`

Have fun!

## Acknowledgement

As I am new to Symfony's World, I made this website by following a tutorial on [Udemy](https://www.udemy.com/course/apprendre-symfony-par-la-creation-dun-site-ecommerce/) by [Mikael Houdoux](https://www.udemy.com/user/houdoux-mikael/). Though, I didn't code along with him as I prefer making my own custom solutions most of the time and understanding what I am writing. I did this by reading the docs at [Symfony Docs website](https://symfony.com/doc/5.4/index.html) and following some screencasts at [SymfonyCasts.com](https://symfonycasts.com).

> This project may not be perfect. But I'll improve it as I am progressing.

## Licence

See [LICENCE.md](LICENCE.md)
