<!--
---
author: hekr23
revision:
    "2025-04-15": "(A, hekr23) First release."
---
-->

![Symfony image](public/img/symfony.svg)

MVC REPORT - A SYMFONY BUILD.
====================


![MVC-Bird image](public/img/title-bird.svg)

Greetings!

![MVC-Report Screenshot](public/img/mvc-report-screenshot-2.png)

Welcome to this repo that contains my, [Herman Karlsson, hekr23](https://www.student.bth.se/~hekr23/dbwebb-kurser/mvc/me/report/public/), mvc-report-build, established in and for the course [mvc v2](https://dbwebb.se/kurser/mvc-v2).

Now, before outlining how you would go about and cloning and setting up this repo locally to be able to peruse it in detail, I'd advice you to first of all considering building your own Symfony-project from scratch: much more fun, much more rewarding.

If you would like to do this, please consult this thorough guide, composed by mos:

[Get going with Symfony](https://github.com/dbwebb-se/mvc/tree/main/example/symfony).


...in relation to the [course-repo](https://github.com/dbwebb-se/mvc/).

...there is also a video of Mikael (mos) walking one through all the steps of the exercise, if that is preferred:

[![Get going with Symfony](https://img.youtube.com/vi/1QVvLGNqTxw/0.jpg)](https://www.youtube.com/watch?v=1QVvLGNqTxw)

...or, for a more general, generic Symfony-setup, consult: [Create your first page in Symfony](https://symfony.com/doc/current/page_creation.html).


Alas, perhaps you are already familiar with all of this, or, for whatever reason, are only interested in taking a look at this specific build. Granted. I'm honored!

Let's then outline how to get the build up and running:


Prerequisites
----------------------------

You have installed PHP in the terminal.

You have installed Composer, the PHP package manager.


What you need to do:
----------------------------

First: Clone the repo.

```bash
# You are in the directory where you want the repo situated
git clone https://github.com/kh3rm/mvc-report.git
```

Second: In the resulting cloned project's root folder, run 'composer install' in your terminal of choice.

```bash
# If you havn't already entered the actual repo-directory
cd mvc-report

#Then:
composer install
```

Third: Install the necessary npm-packages for the build

```bash
# Installs the specific npm-dependencies outlined in package.json
npm install
```

Fourth: Initiate build.

```bash
# Builds the site
npm run build
```

Almost done! The Symfony build should now lie ready to behold.


Local server setup
----------------------------

What now remains is to get it up and running on a local server.

In the project's root folder, run 'symfony server:start' to get the site revving on a local development server.

```bash
# You are in the root mvc-report/ -directory
symfony server:start
```

The project's "/"-destination should now (with default-settings) be accessible at:

https://127.0.0.1:8000


If you for any reason are encountering any problems, maybe https/handshake-related, and the troubleshooting is not yielding any results, an alternative temporary approach is to start a php-server instead, by executing the terminal command 'php -S localhost:8888 -t public' (again, to be slightly redundant, in the project's root folder).

```bash
# You are in the root mvc-report/ -directory
php -S localhost:8888 -t public
```

It should now be accessible at localhost:8888 instead.

Up and running
----------------------------

You should now be able to examine the build in all its glory.

If you are nevertheless still encountering problems, I'd advice you to read through the previously mentioned [thorough guide](https://github.com/dbwebb-se/mvc/tree/main/example/symfony) for clues as to what might be going wrong.

Further Reading
----------------------------
Intrigued? Want to learn more about Symfony and Twig?

Here are some links to satisfy your appetite:

[Symfony 6 Introductory Book - The Fast Track (English)](https://symfony.com/doc/6.4/the-fast-track/en/index.html)

[Symfony - Doc Index](https://symfony.com/doc/current/index.html)

[Symfony - Controller](https://symfony.com/doc/current/controller.html)

[Symfony - Routing](https://symfony.com/doc/current/routing.html)

[Twig for Template Designers](https://twig.symfony.com/doc/3.x/templates.html)

Final words
----------------------------

I hope that you will find all of this interesting and rewarding.

Best regards.

/Herman