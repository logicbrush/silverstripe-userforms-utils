# Silverstripe UserForms Utils

A collection of utilities for the Silverstripe CMS UserForms module. This
includes a shortcode to insert a user form into any content area and a user form
widget.

## Installation

```sh
composer require "logicbrush/silverstripe-userforms-utils"
```

## General Usage

To use the form shortcode we insert `[userform id="x"]` in a HTMLText area where
`x` is the user form page ID.

By default the UserForms module CSS and Javascript requirements will be loaded
when using the shortcode. This can be turned off by setting the following in a
`yml` config file:

```yml
Logicbrush\UserFormsUtils\Shortcodes\UserFormShortcodeProvider:
  block_default_userforms_requirements: true
```
