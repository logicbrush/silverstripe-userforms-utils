# Silverstripe UserForms Utils

A collection of enhancements & utilities for the Silverstripe CMS
[UserForms](https://github.com/silverstripe/silverstripe-userforms) module.

These include:

  - a *shortcode* with which to insert a user form into any content area;
  - a *form widget* that presents a user form (requires
    [silverstripe/widgets](https://github.com/silverstripe/silverstripe-widgets));
  - various new *form fields*.

## Installation

```sh
composer require "logicbrush/silverstripe-userforms-utils"
```

## Shortcode

To use the form shortcode we insert `[userform id="x"]` in a HTMLText area where
`x` is the user form page ID.

By default the UserForms module CSS and Javascript requirements will be loaded
when using the shortcode. This can be turned off by setting the following in a
`yml` config file:

```yml
Logicbrush\UserFormsUtils\Shortcodes\UserFormShortcodeProvider:
  block_default_userforms_requirements: true
```
## Form Widget

Upon installation, the form widget will be available for insertion into any
sidebar area using the CMS interface.

You have the ability to customize display with the following options:

 - **Select a form** - Choose the User Form page to be displayed.
 - **Introductory text** - Specify arbitrary text that precedes the display of
   the form in the sidebar.
 - **Show form title?** -  Choose whether to display the title of the form page.
 - **Show form content?** - Chose whether to display the content of the form
   page.

## Form Fields

This module provides a selection of new field types to use with your user forms.

### HTML5 Date Field

A field that utilizes the native HTML5 `date` input type.  This enables
browser-based input control and validation.

### US State Dropdown Field

A field that provides a dropdown of all US States, including DC.

### Signature Field

A field that collects a signature.  Implemented using
[jSignature](https://willowsystems.github.io/jSignature/#/about/).

