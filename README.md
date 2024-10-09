# wemovies

Wemovies is a mini video library project based on:
- Docker/Docker-compose
- PHP8, Symfony7, Nginx, TailwindCSS
- TheMovieDB API as data source


##  Get Docker/Docker-compose

```bash
  ## Official documentation here:
  https://docs.docker.com/get-docker/
```

## Get your TheMovieDB API Token:

```bash
    ## Signup here 
    https://www.themoviedb.org/signup

    ## Get your API Token here:
    https://www.themoviedb.org/settings/api
```

Setting up the project
==================

1. Clone the projet :

   ```bash
   git clone https://github.com/TIshiro/wemovies.git
   ```

2. Move to the project directory :

   ```bash
   cd wemovies
   ```

3. ⚠️ Update .env

    ```bash
        ## Update these lines in app/.env and app/.env.test with you Token and uncomment them 
        #THE_MOVIE_DB_TOKEN=yourthemoviedbtoken
    ```

4. ⚠️ BE SURE THAT 8080 port is available on your host machine

- If not, update the `compose.yml` file with your desired port
```bash
    ports:
      - "8080:80"
```

## ❇️ Let's up our environment:
1. Move to project root

    ```bash
      cd wemovies
    ```

2. Up our Docker containers

    ```bash
       make up
    ```

3. Install Symfony dependencies
    ```bash
        make install
    ```

4. Go to http://localhost:8080

That's it!

## ❇️ Tests:

    ```bash
    ##PHPUnit tests
      make unit_test
    ```
