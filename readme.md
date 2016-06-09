# Backend

 - [Guide to publish the backend](#guide-to-publish-the-backend)
 - [Lumen](#lumen)

## Guide to publish the backend

> **Note:** make sure you have access to a terminal on your server

### Step 1 - Prepare the server

#### Install composer

> choose one

*Automatic*

Install composer with the installation guide [here](https://getcomposer.org/download/) on your server.

After the successful installation composer is then available in the shell as: `composer`.

*Manually*

>**Note:** `composer` is just available as long as the file is in the project root

Download the `composer.phar` and move it into the project root of the backend. After the `composer.phar` is in the project root, composer is then available as `php composer.phar` in the terminal.

#### PHP version

Check if your PHP version is at least v5

### Step 2 - Prepare the files

>**Note:** you can still change it when it is uploaded to the server

**TODO** - - CORS to the frontend page

### Step 3 - Upload the files

Upload now the backend, with or without `composer.phar`, to the folder on the server where it is accessible by the domain.

**Example:**

`api.elephorum.com` points to `/var/www/api.elephorum.com/`. So the backend should be uploaded to `/var/www/api.elephorum.com/`

### Step 4 - Install vendor with composer

>**Note:** if composer is installed manually, type `php composer.phar` instead of `composer`

Change the directory on the server terminal to the project root of the backend and execute following commands:

`composer install`

`composer dumpautoload`

### Step 5 - Setup database and change .env

#### Database settings

>**Note:** make sure that you have a MYSQL database installed on your sever, preferably accessible by `DOMAIN/phpmyadmin`

Make a new database and a new user on your MYSQL database. Make sure that the new user has full access to the new created database only.

In the `.env` file of the project root there are several options stored, also the database options. In this file you have to change couple of constants:

`DB_HOST` should be `localhost` or `127.0.0.1` - depends on your settings

`DB_DATABASE` to the name of the new created database

`DB_USERNAME` to the name of the new created username

`DB_PASSWORD` the password of the user of DB_USERNAME

#### Email settings

In the `.env` you can change the email settings at the section with the `EMAIL_` prefix.

*Options*:

`MAIL_FROM` - the mail where it comes from -> your email

`MAIL_NAME` - the username of the email

`MAIL_PASSWORD` - the password of the email

`MAIL_HOST` - the SMTP / POP3 host (Gmail standard: smtp.google.com)

`MAIL_SUBJECT_INVITE` - the subject if a person gets invited

`MAIL_SUBJECT_FORGOT` - the subject if a person forgot his password

### Step 6 - Migrate database

After setting up the database connection we are ready for the final step - the database migration, that all the needed data will be stored to the database.

Change the directory in your terminal to the project root of the backend and execute following commands:

`php artisan migrate`

`php artisan db:seed`

### Errors?

**Server response with 500 code**

If the server response with a 500 it could be that `./app/storage` of Lumen has not the right permission. To fix that go into the project root of the backend in the terminal and type following command:

`sudo chmod -R 777 app/storage`

**No files are uploaded**

You either have no `uploads` folder in the project root or not the right permission. To fix that write following command in the project root:

`sudo chmod -R 755 uploads`


## Lumen

### Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

### Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

### Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

#### License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
