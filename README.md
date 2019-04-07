# Stazify [![Build Status](https://travis-ci.com/alchermd/stazify.svg?token=vzhgie4S46NByqdppmGS&branch=master)](https://travis-ci.com/alchermd/stazify)

A web application that connects companies and students with software

***NOTE: This is an open copy of the original Stazify before being transferred to AMA Apalit. No affiliation is maintained to the current running version of the software***

## Introduction

`Stáž` (noun) - a Czech word that roughly translates to _fellowship_, _internship_, or _practicum_. `Stazify` is a web application that connects students enrolled in computer related courses with companies that are in need of talented interns to bolster their workforce.

## Requirements

This app requires:

- PHP 7.1.3 or higher
- Composer
- Yarn (or NPM)
- PostgreSQL

If you want to have the best development experience, I recommend using [Laravel Homestead](https://laravel.com/docs/homestead) as your dev environment.

## Installation - Homestead (Recommended)

1. Clone the repository

2. Install the composer dependencies

```bash
$ composer install
```

3. Generate the `Homestead.yaml` file

```bash
$ ./vendor/bin/homestead make
Homestead Installed!
```

At this point, you may want to customize the `Homestead.yaml` to your liking before we start up the virtual machine.

4. Start the Homestead VM

```bash
$ vagrant up
```

5. To access the app using the domain mapped by Homestead (`http://stazify.test` by default), you need to create the mapping in your hosts file

```bash
# In your /etc/hosts file
127.0.0.1 localhost

# add this line
192.168.10.10 stazify.test
```

6. You're pretty much good to go! Do the following preparatory commands to finish up your installation:

```bash
$ vagrant ssh
vagrant@stazify: $ cd code
vagrant@stazify: $~/code cp .env.example .env       # then customize your .env file
vagrant@stazify: $~/code php artisan key:generate
vagrant@stazify: $~/code php artisan migrate        # make sure to create the database first
vagrant@stazify: $~/code php artisan db:seed        
vagrant@stazify: $~/code php artisan storage:link
```

Your app is now ready. Visit `http://stazify.test` on your browser to start using Stazify.

## Installation - Without Homestead

Install the Composer and Node dependencies.

```bash
$ composer install
$ npm install
```

After creating your database, copy the `.env.example` file into an `.env` file and update the necessary fields

```bash
$ cp .env.example .env
$ nano .env # Or whatever your preferred editor
# Change these as necessary
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=johnalcher
DB_USERNAME=username
DB_PASSWORD=password

# Customize the mail variables while you're here
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=ssl
MAIL_ADMIN=admin@example.com
```

And then generate an application key for security purposes

```bash
$ php artisan key:generate
```

You can now run the migrations without any problems

```bash
$ php artisan migrate
```

Seed the initial data while you're at it:

```bash
$ php artisan db:seed
```

And make sure that the storage symlink is properly setup.

```bash
$ php artisan storage:link
```

Start the development server and see the application in action!

```bash
$ php artisan serve
Laravel development server started: <http://127.0.0.1:8000>
```

(Optional) Get some awesome IDE helper goodies with the following commands:

```bash
$ php artisan ide-helper:generate # Laravel Facades
$ php artisan ide-helper:models   # Eloquent models
$ php artisan ide-helper:meta     # PhpStorm meta file
```

## Testing

`Stazify` uses PHPUnit for feature and unit tests.

```bash
$ ./vendor/bin/phpunit
# or when using Homestead
$ vagrant ssh
vagrant@stazify: $ cd code
vagrant@stazify: $~/code ./vendor/bin/phpunit
```

## License

This software is developed by John Alcher Doloiras <johnalcherdoloiras@gmail.com> and Rizalyn Dela Cruz. See the [LICENSE](LICENSE) file for more information.

