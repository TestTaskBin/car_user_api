#!/usr/bin/env bash

XUID="$(id -u)"
XGID="$(id -g)"
DIR="$(pwd)"


docker run -it --user "$XUID:$XGID" \
    -v "$DIR/app:/app" --workdir "/app" \
     composer:2.4 bash || exit 1
fi
