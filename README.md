# wemovies

Wemovies is a mini video library project based on:
- Docker/Docker-compose
- PHP8, Symfony6, Nginx
- TheMovieDB API as data source

Setting up the project
==================

## ❇️ Get Docker/Docker-compose

```bash
## Official documentation here: 
https://docs.docker.com/get-docker/
```

## ❇️ Get your TheMovieDB API Token:

```bash
## Signup here 
https://www.themoviedb.org/signup
## Get your API Token here:
https://www.themoviedb.org/settings/api
```

## ❇️ Update your environment:

```bash
## Update these lines in app/.env and app/.env.test with you Token and uncomment them 
#THE_MOVIE_DB_TOKEN=yourthemoviedbtoken
```

## ⚠️ ️Warning

__**BE SURE THAT 8080 port is available on your host machine**__

- If not, update the `docker-compose.yml` file with your desired port
```bash
    ports:
      - "8080:80"
```

## ❇️ Up your environment:

```bash
docker-compose up -d --build
```

- Go to http://localhost:8080

Enjoy!

## ❗ HintPoints:

- Your project doesn't start:

```bash
docker exec -it symfony-app-php bash

composer install
```

## ❇️ Tests:

```bash
docker exec -it symfony-app-php bash

##Integrations tests
vendor/bin/simple-phpunit

##Fucntionnals tests
vendor/bin/behat
```
