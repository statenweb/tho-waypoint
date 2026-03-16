#!/bin/bash
set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
if [ -f "$SCRIPT_DIR/.env" ]; then
  export DB_NAME=$(grep -m1 '^DB_NAME=' "$SCRIPT_DIR/.env" | cut -d'=' -f2- | tr -d "'\"")
  export DB_USER=$(grep -m1 '^DB_USER=' "$SCRIPT_DIR/.env" | cut -d'=' -f2- | tr -d "'\"")
  export DB_PASSWORD=$(grep -m1 '^DB_PASSWORD=' "$SCRIPT_DIR/.env" | cut -d'=' -f2- | tr -d "'\"")
  export DB_HOST=$(grep -m1 '^DB_HOST=' "$SCRIPT_DIR/.env" | cut -d'=' -f2- | tr -d "'\"")
  export SITE_URL=$(grep -m1 '^WP_HOME=' "$SCRIPT_DIR/.env" | cut -d'=' -f2- | tr -d "'\"")
  export SITE_TITLE=$(grep -m1 '^SITE_TITLE=' "$SCRIPT_DIR/.env" | cut -d'=' -f2- | tr -d "'\"")
fi

echo "=== Waypoint First-Time Setup ==="

# Exit if already installed
if wp core is-installed 2>/dev/null; then
  echo "WordPress already installed. Skipping setup."
  exit 0
fi

# Require env vars
: "${DB_NAME:?Required env var DB_NAME not set}"
: "${DB_USER:?Required env var DB_USER not set}"
: "${DB_PASSWORD:?Required env var DB_PASSWORD not set}"
: "${SITE_URL:?Required env var SITE_URL not set}"
: "${SITE_TITLE:?Required env var SITE_TITLE not set}"

DB_HOST=${DB_HOST:-localhost}
ADMIN_EMAIL=${ADMIN_EMAIL:-mat@waypoint.agency}
ADMIN_PASSWORD=$(openssl rand -base64 16)

# Install WordPress
echo "Installing WordPress..."
wp core install \
  --url="$SITE_URL" \
  --title="$SITE_TITLE" \
  --admin_user="waypoint_admin" \
  --admin_password="$ADMIN_PASSWORD" \
  --admin_email="$ADMIN_EMAIL" \
  --skip-email

echo ""
echo "========================================="
echo "Admin URL:  $SITE_URL/wp-admin"
echo "Username:   waypoint_admin"
echo "Password:   $ADMIN_PASSWORD"
echo "SAVE THIS PASSWORD — shown once only."
echo "========================================="
echo ""

# Detect and activate theme
THEME_SLUG=$(basename "$(find web/wp-content/themes -maxdepth 1 -mindepth 1 -type d | head -1)")
echo "Activating theme: $THEME_SLUG"
wp theme activate "$THEME_SLUG"

# Permalinks
wp option update permalink_structure '/%postname%/'
wp rewrite flush

# Plugins
wp plugin install advanced-custom-fields --activate 2>/dev/null || true
wp plugin install wordpress-seo --activate 2>/dev/null || true
wp plugin deactivate hello akismet 2>/dev/null || true

# Site options
wp option update timezone_string 'America/New_York'
wp option update blogdescription ''
wp option update default_comment_status 'closed'
wp option update default_ping_status 'closed'

echo "=== Setup complete. Run build.sh next. ==="
