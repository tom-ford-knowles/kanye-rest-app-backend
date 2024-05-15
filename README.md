# Kanye Rest API Project

This is a Laravel 10/PHP 8.2 project which allows you to retrieve a set of random quotes from the Kanye Rest API.

## Setup

This project uses Laravel Sail to provide a docker container for ease of setup and I have provided a bash script to download everything needed to get up and running. The steps to get fully up and running are below:

-   Clone this repo to your local machine
-   Navigate to the repo so that you are inside it
-   Type the command `./setup.sh` and this will download all composer dependencies.
-   Type `./vendor/bin/sail up -d`

## Running the test suite

This project is complete with a test suite which tests the controllers used to register, login and retrieve quotes. Once the setup step has been completed, you may run

    ./vendor/bin/sail artisan test

This will then test each element listed above.
