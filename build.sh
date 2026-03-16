#!/bin/bash
set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

echo "=== Waypoint Build ==="

# Root composer install
echo "Running root composer install..."
composer install --no-dev

# Run first-time setup if WordPress not installed
if ! wp core is-installed --path="$SCRIPT_DIR/web" 2>/dev/null; then
  echo "WordPress not installed — running first-time setup..."
  bash "$SCRIPT_DIR/setup.sh"
fi

# NVM
export NVM_DIR="$HOME/.nvm"
if [ ! -s "$NVM_DIR/nvm.sh" ]; then
  echo "Installing NVM..."
  curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash
fi
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
nvm install 20
nvm use 20

# Theme composer install + build
THEME_DIR="$SCRIPT_DIR/web/wp-content/themes/tho"
echo "Running theme build in $THEME_DIR..."
cd "$THEME_DIR"
composer install --no-dev
npm i
npm run prod
rm -rf node_modules
cd "$SCRIPT_DIR"

# WP cache and rewrite (only if WP is installed)
if wp core is-installed --path="$SCRIPT_DIR/web" 2>/dev/null; then
  echo "Flushing WP cache and rewrites..."
  wp cache flush --path="$SCRIPT_DIR/web"
  wp rewrite flush --path="$SCRIPT_DIR/web"
  wp core update-db --path="$SCRIPT_DIR/web"
fi

echo "=== Build complete ==="
