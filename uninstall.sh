#!/usr/bin/env bash

# terminate script if any command fails
set -e

echo "Uninstalling [nevermind]"

if [ -f /usr/bin/nevermind ]; then
    echo "Removing executable"
    rm -rf /usr/bin/nevermind
fi

docker inspect --type=image nevermind:latest > /dev/null 2>&1 && \
echo "Removing docker image" && \
docker image rm --force nevermind || true

echo "Done"
