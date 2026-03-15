#!/usr/bin/env bash
#
# create-pages.sh — Create WordPress page structure for The Hidden Opponent
#
# Usage: wp eval-file scripts/create-pages.sh
#   or:  wp cli script scripts/create-pages.sh (requires wp-cli package)
#
# This script creates all required pages with correct slugs and sets the
# Home page as the static front page.

set -euo pipefail

# Define pages: "Title|slug"
PAGES=(
  "About|about"
  "Team|team"
  "Board of Directors|board"
  "Our Impact|impact"
  "Programs|tho-programs"
  "Campus Captains|campus-captains"
  "Coaches & Professionals|coaches-and-professionals"
  "Resources|resources"
  "The Mindset Experience|the-mindset-experience"
  "Support|support"
  "Host a THO Game|host-a-tho-game"
  "Donate|donate"
  "Privacy Policy|privacy-policy"
)

echo "Creating THO page structure..."

for entry in "${PAGES[@]}"; do
  IFS="|" read -r title slug <<< "$entry"

  # Check if page with this slug already exists
  existing=$(wp post list --post_type=page --name="$slug" --format=ids 2>/dev/null || true)

  if [ -n "$existing" ]; then
    echo "  ✓ Page already exists: $title ($slug) [ID: $existing]"
  else
    page_id=$(wp post create \
      --post_type=page \
      --post_title="$title" \
      --post_name="$slug" \
      --post_status=publish \
      --porcelain)
    echo "  ✓ Created: $title ($slug) [ID: $page_id]"
  fi
done

# Create the Home page and set it as the static front page
home_slug="home"
existing_home=$(wp post list --post_type=page --name="$home_slug" --format=ids 2>/dev/null || true)

if [ -n "$existing_home" ]; then
  home_id=$existing_home
  echo "  ✓ Home page already exists [ID: $home_id]"
else
  home_id=$(wp post create \
    --post_type=page \
    --post_title="Home" \
    --post_name="$home_slug" \
    --post_status=publish \
    --porcelain)
  echo "  ✓ Created: Home ($home_slug) [ID: $home_id]"
fi

# Set static front page
wp option update show_on_front page
wp option update page_on_front "$home_id"
echo "  ✓ Set static front page to Home [ID: $home_id]"

echo ""
echo "Done! All THO pages created successfully."
