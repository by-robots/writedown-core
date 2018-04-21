# ByRobots\WriteDown
A simple Markdown blogging platform.

[![Build Status](https://travis-ci.org/byrobots/writedown-core.svg?branch=master)](https://travis-ci.org/byrobots/writedown-core)
[![Code Coverage](https://scrutinizer-ci.com/g/byrobots/writedown-core/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/byrobots/writedown-core/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/byrobots/writedown-core/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/byrobots/writedown-core/?branch=master)

## DO NOT USE
ByRobots\WriteDown is currently in development. There will be breaking changes until a
release is tagged.

## Installation
These instructions are temporary.

1. `git clone git@github.com:byrobots/writedown.git`
2. `cd writedown`
3. `cp .env.sample .env` and edit accordingly.
4. `npm install && composer install`
5. `./vendor/bin/phinx migrate`
6. `./vendor/bin/phinx seed:run`
7. `grunt default`

## Automated Testing
To run automated testing execute `./vendor/bin/phpunit` after installing all
development dependencies.

## Migrations
Migrations are built using [Phinx](https://phinx.org/). Documentation is
available [here](http://docs.phinx.org/en/latest/index.html).


