# CSS

CSS (Competitive Scoring System) is an app that I built to help keep score at our local shooting sports events.

# Run Locally With Docker

You can run this app as a standalone app on a non development machine / php web server with the help of `docker`.

After nstalling [docker](https://docs.docker.com/get-docker/), navigate to the folder where you copied / cloned this project and run the following [bash](https://www.google.com/search?q=install+bash) script.

```bash
./scripts/docker-up.sh
```

You can then open a web browser to [http://localhost](http://localhost), and begin using the application.

## Configuring the environment

If you are wanting to tweak specific details about php, mysql or nginx, you can the appropriate files located in `./env/`.

## Modifying the App

Now that you have run the above mentioned script, you have a complete runtime and development environment, you can modify php files directly.

To can run commands such as `npm install` by executing something like this;

```bash
docker-compose exec app npm install
```

A simple web based `database management` system called [Adminer](https://www.adminer.org/) is also available for you locally at [http://localhost:8080](http://localhost:8080).

# To set up manually

* Prepare your .env file there with database connection and other settings
* Run `"composer install"` command
* Run `"php artisan migrate --seed"` command. 
  * **Notice:** seed is important, because it will create the first admin user for you.
* Run `"php artisan key:generate"` command.
* Run `"php artisan passport:install"` command.
* Run `"npm install"` command.
* Run `"npm run dev"` command.

# Initial Log in

* `Email:` admin@admin.com
* `Password:` password

> **Notice:** if you use CKEditor fields, there are a few more commands to launch for Laravel Filemanager package:

```bash
php artisan vendor:publish --tag=lfm_config
php artisan vendor:publish --tag=lfm_public
```

# Setting up a certificate

See https://mindsers.blog/post/https-using-nginx-certbot-docker/

Create a new certificate with the following;

```
docker compose run --rm  certbot certonly --webroot --webroot-path /var/www/certbot/ -d yhecscores.com -d www.yhecscores.com
```

The certificate can be renewed with;

```
docker-compose run --rm certbot renew
```