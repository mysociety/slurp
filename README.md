# Slurp

A service to retrieve stats from various instances of mySociety sites.

[![Build Status](https://scrutinizer-ci.com/g/mysociety/slurp/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mysociety/slurp/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mysociety/slurp/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mysociety/slurp/?branch=master)

## Running

* `./commander retrieve`: Get the latest stats from all the instances.
* `./commander retrieve {{id}}`: Get the latest stats from the instance with ID `{{id}}`.
* `./commander retrieve --onlyDue`: Only get stats from instances which are due to be retrieved.

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
