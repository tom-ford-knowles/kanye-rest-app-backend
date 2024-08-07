# Kanye Rest API Project

This is a Laravel 11/PHP 8.2 project which allows you to retrieve a set of random quotes from the Kanye Rest API.

## Setup

This project uses Laravel Sail to provide a docker container for ease of setup and I have provided a bash script to download everything needed to get up and running. The steps to get fully up and running are below:

-   Clone this repo to your local machine
-   Navigate to the repo so that you are inside it
-   Run the command `./setup.sh` and this will download all composer dependencies.
-   Run `./vendor/bin/sail up -d`
-   Wait for around 1 minute for the database to finish booting
-   Run `./vendor/bin/sail artisan migrate`
-   The application is then ready to go

## Running the test suite

This project is complete with a test suite which tests the controllers used to register, login and retrieve quotes. Once the setup step has been completed, you may run

    ./vendor/bin/sail artisan test

This will then test each element listed above.

## Testing the application

Below is a JSON Postman collection containing all endpoints. Copy this block of JSON then hit import inside Postman to generate the collection.

    {"info":{"_postman_id":"736dcdc3-943c-47a6-a18d-ea9ef171129c","name":"Kanye Rest Laravel Project","schema":"https://schema.getpostman.com/json/collection/v2.1.0/collection.json","_exporter_id":"11157529"},"item":[{"name":"Register","protocolProfileBehavior":{"disabledSystemHeaders":{"accept":true}},"request":{"method":"POST","header":[{"key":"Accept","value":"application/json"}],"body":{"mode":"raw","raw":"{\n    \"name\": \"Test\",\n    \"email\": \"test@test.com\",\n    \"password\": \"*Zc!PCTHtZ*Fdi3d\",\n    \"password_confirmation\": \"*Zc!PCTHtZ*Fdi3d\"\n}","options":{"raw":{"language":"json"}}},"url":{"raw":"http://localhost/api/register","protocol":"http","host":["localhost"],"path":["api","register"]}},"response":[]},{"name":"Login","protocolProfileBehavior":{"disabledSystemHeaders":{"accept":true}},"request":{"method":"POST","header":[{"key":"Accept","value":"application/json"}],"body":{"mode":"raw","raw":"{\n    \"email\": \"test@test.com\",\n    \"password\": \"*Zc!PCTHtZ*Fdi3d\"\n}","options":{"raw":{"language":"json"}}},"url":{"raw":"http://localhost/api/login","protocol":"http","host":["localhost"],"path":["api","login"]}},"response":[]},{"name":"Quotes","protocolProfileBehavior":{"disabledSystemHeaders":{"accept":true}},"request":{"auth":{"type":"bearer","bearer":[{"key":"token","value":"1|O5VSQFFdpnz063eoYbCak1bhsmoqXhPd5FKUH9Su8c6b72a4","type":"string"}]},"method":"GET","header":[{"key":"Accept","value":"application/json"}],"url":{"raw":"http://localhost/api/quotes","protocol":"http","host":["localhost"],"path":["api","quotes"]}},"response":[]}]}

To run the endpoints:

1.  Register a user using the POST Register endpoint. Example details are set here. This will return a bearer token. You can use this to access the GET Quotes endpoint or use the POST Login endpoint to generate a new token.
2.  If this token expires, use the POST Login endpoint with your email and password to generate a new token.
3.  Replace the token in the Authorisation section of the GET Quotes endpoint with the token you have generated. You can then run the request and get a list of 5 quotes. If you run the request again you will get a new list of quotes.

Elements:

-   [x] A rest API that shows 5 random Kayne West quotes (must) - /quotes
-   [x] There should be an endpoint to refresh the quotes and fetch the next 5 random quotes (must) - /quotes?fetch_new_quotes=1
-   [x] Authentication for these APIs should be done with an API token, not using any package - Achieved using Laravel Sanctum
-   [x] The above features are tested with Feature tests (must) - tests/Feature/Http/Controllers
-   [x] Provide a README on how we can set up and test the application (must)
-   [x] Implementation of API using Laravel Manager Design Pattern (Plus)
-   [x] Making third-party API response quick by cache (Plus)
