[![Build Status](https://travis-ci.org/brackets-extension-badges/badge-provider-nodejs.svg?branch=master)](https://travis-ci.org/brackets-extension-badges/badge-provider-nodejs)

# PHP badge provider

![brackets-extension-badges](https://cloud.githubusercontent.com/assets/17952318/24578041/b908d05e-16d8-11e7-9152-47b66656ee0e.gif)

---

## [<p align="center">brackets-extension-badges.github.io</p>](https://brackets-extension-badges.github.io)

---

**Brackets extension badges** are download counters for your [Brackets](https://github.com/adobe/brackets) extensions, as Adobe doesn't provide any official way to retrieve statistics, even for your own extension.

This repository is the PHP version of the server, which manages both statistics databases and `.svg` badge generation.
It written with the [Lumen](https://github.com/laravel/lumen-framework) framework

#### Warning
The PHP version of the server is the original one, but **the development has been abandoned** in favour of the Node.js version, currently available at [badges.ml](https://badges.ml/list.json)

## Routes

- `/` - Redirects to [brackets-extension-badges.github.io](https://brackets-extension-badges.github.io)
- `/EXTENSION_NAME/total.svg` - A badge showing the total number of downloads
- `/EXTENSION_NAME/last-version.svg` - A badge showing number of downloads for the latest version of the extension
- `/EXTENSION_NAME/week.svg` - A badge showing the number of downloads during the last 7 days
- `/EXTENSION_NAME/day.svg` - A badge showing the average downloads per day, based on the last 7 days
- `/list.json` - A list of all extensions with total download numbers.

## Finding the extension name

The *name* of an extension is definded in the `package.json` file, at the root of the extension.

## Deployment

The badge provider is a Lumen application with a MySQL database. It can be easily deployed with [Laradock](https://github.com/laradock/laradock), a Docker PHP development environment.

Deploying requires `git`, `docker` and `docker-compose`.

Check out the [Deployment](https://github.com/brackets-extension-badges/badge-provider-php/wiki/Deployment) page of the wiki for detailled steps.
