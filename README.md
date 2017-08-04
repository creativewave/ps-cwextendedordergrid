# Extended Order Grid

## About

Extended Order Grid is a Prestashop module for extending order data displayed in orders grid.

This module is currently used in production websites with Prestashop 1.6 and PHP 7+.

## Installation

This module is best used with Composer managing your Prestashop project globally. This method follows best practices for managing external dependencies of a PHP project.

Create or edit `composer.json` in the Prestashop root directory:

```json
"repositories": [
  {
    "type": "git",
    "url": "https://github.com/creativewave/ps-cwextendedordergrid"
  }
],
"require": {
  "creativewave/ps-cwmedia": "^1"
},

```

Then run `composer update`.

## Todo

* Improvement: handle orders with multiple invoices.
* Feature: set options to choose which data are appended to order grid.
* Unit tests
