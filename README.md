# Game refactor

![TravisCI build](https://travis-ci.com/roelofjan-elsinga/game-refactor.svg?branch=production)
[![codecov](https://codecov.io/gh/roelofjan-elsinga/game-refactor/branch/production/graph/badge.svg)](https://codecov.io/gh/roelofjan-elsinga/game-refactor)

This is a refactored (and tested) version of [this game](https://github.com/jbrains/trivia/tree/master/php).

## Installation
The namespace is PSR-4 autoloaded using Composer, so you'll need to generate the autoload file:

```terminal
composer dump-autoload
```

Then you can use the GameRunner in the src/ folder to simulate a game:

```terminal
php GameRunner.php
```

## Testing
To test this application, you'll need to install the dev dependencies:

```terminal
composer install
```

After which you can run the test suite:

```terminal
./vendor/bin/phpunit
```
