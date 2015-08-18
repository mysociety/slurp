# Slurp

A service to retrieve stats from various instances of mySociety sites.

[![Build Status](https://img.shields.io/scrutinizer/build/g/mysociety/slurp.svg)](https://scrutinizer-ci.com/g/mysociety/slurp/)
[![Code Quality](https://img.shields.io/scrutinizer/g/mysociety/slurp.svg)](https://scrutinizer-ci.com/g/mysociety/slurp/)

## Running

Use `./commander` to retrieve stats. `./commander retrieve:one {{id}}`, or `./commander retrieve:all`.

## Developing

### Requirements

* PHP 5.4.
* A PostgreSQL database.

### Configuration

Copy the `conf/conf.env-example` file to `conf/conf.env` and adjust parameters accordingly.

### Libraries

Libraries are handled using [Composer](https://getcomposer.org/). Do a `php composer.phar install`.

### Migrations

Migrations are handled using [Phinx](https://phinx.org/). To run them, `vendor/bin/phinx migrate -c conf/phinx.php` (after you've installed the Composer requirements).
