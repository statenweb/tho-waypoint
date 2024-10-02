# Statenweb starter theme

## Local setup

1. Check out this repo
2. Map (no pun intended) a local domain, e.g. socialimpact.tst to `{REPO ROOT}/web`
3. Create a local DB
4. Copy .env.example to .env
5. Update the `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_HOST`, `WP_ENV`, `WP_HOME`, `WP_SITEURL`, as applicable
6. Navigate to the mapped location (from above)
7. Install WordPress and plugins by running composer install
8. Navigate to the mapped domain
9. Walk through the default install of WordPress
10. The next, optional steps are, locally, to:
    - Activate WP Migrate DB Pro + the WP Migrate DB Pro Media Add On.

At this point you will have a live copy of a WordPress instance without the theme.

The next step is to go to the theme directory and run:
1. `composer install`
2. `npm install`
3. `npm run watch`

This will run webpack's watch functionality and will compile your JS/SCSS and run the webpack build process whenever any assets it is watching are changed.

That's all, you're set to get started.

## Theme source code and autoloadin
Theme source code is located in `Vicotria` directory.
We are using PSR4 autoloading, keep that in mind when extending theme code.