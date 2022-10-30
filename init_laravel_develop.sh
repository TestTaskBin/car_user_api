#!/usr/bin/env bash

XUID="$(id -u)"
XGID="$(id -g)"
DIR="$(pwd)"

# compose config update
cp "$DIR/templates/docker-compose.yml"  "$DIR/docker-compose.yml" || exit 1
#cp "$DIR/templates/docker-compose_host.yml"  "$DIR/docker-compose.yml" || exit 1
sed -i "s/%USER%/${XUID}:${XGID}/"  "$DIR/docker-compose.yml" || exit 1

# new project
if test ! -d "$DIR/app"
then
mkdir -p "$DIR/app" || exit 1
docker run -it --user "$XUID:$XGID" \
    -v "$DIR/app:/app" --workdir "/app" \
     composer:2.4 composer create-project --no-cache laravel/laravel . 9.3 || exit 1
fi

# first run after chckout
if test ! -f "$DIR/app/.env"
then
cp "$DIR/app/.env.example"  "$DIR/app/.env" || exit 1
docker run -it --user "$XUID:$XGID" \
    -v "$DIR/app:/app" --workdir "/app" \
     composer:2.4 composer install || exit 1
docker run -it --user "$XUID:$XGID" \
    -v "$DIR/app:/app" --workdir "/app" \
     composer:2.4 php artisan migrate --force || exit 1
docker run -it --user "$XUID:$XGID" \
    -v "$DIR/app:/app" --workdir "/app" \
     composer:2.4 php artisan key:generate || exit 1
docker run -it --user "$XUID:$XGID" \
    -v "$DIR/app:/app" --workdir "/app" \
     composer:2.4 php artisan db:seed --force || exit 1
fi


