# Silverstripe UserForms Utils

[![Build Status](https://travis-ci.com/logicbrush/silverstripe-userforms-utils.svg?branch=master)](https://travis-ci.com/logicbrush/silverstripe-userforms-utils)
[![codecov.io](https://codecov.io/github/logicbrush/silverstripe-userforms-utils/coverage.svg?branch=master)](https://codecov.io/gh/logicbrush/silverstripe-userforms-utils?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/logicbrush/silverstripe-userforms-utils/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/logicbrush/silverstripe-userforms-utils/?branch=master)
[![License](https://poser.pugx.org/logicbrush/silverstripe-userforms-utils/license)](LICENSE)

A collection of utilities for the Silverstripe CMS UserForms module. This includes a shortcode to insert a user form into any content area and a user form widget.

## Requirements

* Silverstripe Framework 4.x
* [Silverstripe UserForms 5.x](https://github.com/silverstripe/silverstripe-userforms/)

## Installation (with composer)

```sh
composer require "logicbrush/silverstripe-userforms-utils"
```

## Usage

To use the user forms shortcode we can insert `[userform id="x"]` in the HTMLText area where `x` is the user form page ID.
