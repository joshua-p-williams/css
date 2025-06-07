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

# Setting up a new certificate

See https://mindsers.blog/post/https-using-nginx-certbot-docker/

## 1. Set up the app.conf to run on port 80 for your domain name


Open the `env/nginx/conf.d/app.conf`, you will see 3 server sections, you want to ensure that when installing the domain for the first time, the only one you run is the second one on port 80 with your domain name in the server_name section.

Then restart the services "docker-compose up

## 2. Create the new certificate

Create a new certificate with the following;

```bash
docker-compose run --rm certbot certonly \
  --webroot \
  --webroot-path=/var/www/certbot \
  -d yhecscores.com -d www.yhecscores.com \
  --email you@example.com \
  --agree-tos \
  --no-eff-email
```

> 📌 Replace `you@example.com` with your actual email — Let’s Encrypt uses this for renewal reminders and expiry notices.

## 3. Modify your app.conf to have server for 443

Now you can stop the services `docker-compose down` and modify the `env/nginx/conf.d/app.conf` with both the last 2 server specifications for port 80 and 443 with your domain specified.

You can now bring everything back up normally `./scripts/docker-up.sh`.

# Renewing the certificate

The certificate can be renewed with;

```
docker-compose run --rm certbot renew
```
