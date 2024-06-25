# RUNNING LOCALLY

---------------------------------------------------------

## Setup Local Environment (Step 1)

- Set a sail alias
```shell
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
````
- Then either use laravel herd or sail to start the local environment

### Laravel HERD + DB Engin
- https://herd.laravel.com/ - PHP environment
- https://dbngin.com/ - Database Environment

### Docker (Sail)
- Install composer dependencies
 ```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
- Run Sail (Detached)
```shell
sail up -d
```
---------------------------------------------------------
## Running PHPUnit Tests (Step 2)
```shell
sail test
```
