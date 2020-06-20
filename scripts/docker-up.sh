#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $DIR/..

# If we can count more than just the "heading" then we will assume it's already running
dcpsCount=$(docker-compose ps | wc -l)
dockerComposeRunning=0
if [ $dcpsCount -gt 2 ]; then
  echo ""
  echo "Site is already running..."
  echo "To shut the site down run;"
  echo "docker-compose down"
  echo ""
  dockerComposeRunning=1
else
  docker-compose up -d
  # if it fails to start, might require elevation
  # to build initial images
  if [ $? != 0 ]; then
    sudo docker-compose up -d
  fi

fi

if [ ! -f .docker-env ]; then

  # Wait on the database to become available
  echo "Waiting on processes to start..."
  psCount=$(docker-compose ps | grep Up | wc -l)
  while [ ! $psCount -gt 3 ]; do
    sleep 1
    psCount=$(docker-compose ps | grep Up | wc -l)
  done

  echo "Waiting on database to become available..."
  while ! docker-compose exec db mysqladmin ping -prootpw -hlocalhost --silent; do
    sleep 1
  done
  sleep 10 # Give more time for good measure
  echo "Database is now available..."

  echo "Creating default .env file..."
  if [ ! -f .env ]; then
    cp .env.example .env
  fi

  echo "Installing dependencies..."
  docker-compose exec app composer install

  echo "Generating application key..."
  docker-compose exec app php artisan key:generate

  echo "Seeding database..."
  docker-compose exec app php artisan migrate --seed

  echo "Setting up passport..."
  docker-compose exec app php artisan passport:install

  echo "Installing web components..."
  docker-compose exec app npm install
  docker-compose exec app npm run dev

  echo "#!/bin/bash
export SETUP_ON=$(date)
" > .docker-env

  echo ""
  echo "**********************"
  echo "*        Done!       *"
  echo "* Open a browser to; *"
  echo "*  http://localhost  *"
  echo "**********************"
  echo ""

fi
