find . -type d -maxdepth 1 -exec sh -c 'if [ -e "{}"/.env.example ]; then cp "{}"/.env.example "{}"/.env; fi' \;

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs \

php artisan key:generate
