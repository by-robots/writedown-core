# WriteDown: Core
This library is consumed by projects and provides the core functionality of
WriteDown. It provides a simple API that can be consumed, and various classes
that can be used to provide related functionality.

[![Build Status](https://travis-ci.org/by-robots/writedown-core.svg?branch=master)](https://travis-ci.org/by-robots/writedown-core)
[![Code Coverage](https://scrutinizer-ci.com/g/by-robots/writedown-core/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/by-robots/writedown-core/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/by-robots/writedown-core/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/by-robots/writedown-core/?branch=master)

## DO NOT USE
WriteDown is currently in development. There will be breaking changes until a
release is tagged.

## Automated Testing
WriteDown features extensive unit test coverage. All features should be tested,
as bugs are found they should have failings tests added before they are fixed so
regressions can be avoided.

To run tests, install all dependencies with `composer install` and then run
`./vendor/bin/phpunit`.

## Structure Rationale
The core library has been written in such a way that it won't limit how
WriteDown is used. It can be used as part of a project that provides a simple
HTML and CSS frontend, as in the base
[WriteDown](https://github.com/by-robots/writedown) project. Alternatively, a
wrapper can be added to expose the data as a REST API. This can then be used by
a "fancier" frontend, provided by [React](https://reactjs.org/) for example.
Just do whatever works!
