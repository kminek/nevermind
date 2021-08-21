#!/usr/bin/env bash

# terminate script if any command fails
set -e

echo "Installing [nevermind]"

echo "Building docker image"
docker build --no-cache -t nevermind .

echo "Adding executable"
rm -rf /usr/bin/nevermind
cat > /usr/bin/nevermind <<EOF
#!/usr/bin/env bash
test -t 1 && USE_TTY="-t"
docker run \${USE_TTY} --volume \$(pwd):/app/storage --rm nevermind \$@
EOF
chmod +x /usr/bin/nevermind

echo "Done"
