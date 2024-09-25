# Silverstripe UserForms Utils

[![Build Status](https://travis-ci.com/logicbrush/silverstripe-userforms-utils.svg?branch=master)](https://travis-ci.com/logicbrush/silverstripe-userforms-utils)
[![codecov.io](https://codecov.io/github/logicbrush/silverstripe-userforms-utils/coverage.svg?branch=master)](https://codecov.io/gh/logicbrush/silverstripe-userforms-utils?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/logicbrush/silverstripe-userforms-utils/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/logicbrush/silverstripe-userforms-utils/?branch=master)
[![License](https://poser.pugx.org/logicbrush/silverstripe-userforms-utils/license)](LICENSE)

A collection of utilities for the Silverstripe CMS UserForms module. This
includes a shortcode to insert a user form into any content area and a user form
widget.

## Requirements

* Silverstripe Framework 4.x
* [Silverstripe UserForms 5.x](https://github.com/silverstripe/silverstripe-userforms/)

## Installation (with composer)

```sh
composer require "logicbrush/silverstripe-userforms-utils"
```

## Usage

To use the form shortcode we insert `[userform id="x"]` in a HTMLText area where `x` is the user form page ID.

By default the UserForms module CSS and Javascript requirements will be loaded
when using the shortcode. This can be turned off by setting the following in a
`yml` config file:

```yml
Logicbrush\UserFormsUtils\Shortcodes\UserFormShortcodeProvider:
  block_default_userforms_requirements: true
```
