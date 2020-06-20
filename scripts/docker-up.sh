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

  echo "Installing web components..."
  docker-compose exec app npm install
  docker-compose exec app npm run dev

  echo "#!/bin/bash
export SETUP_ON=$(date)
" > .docker-env
fi
