# Magento 2 Module - Backend

<div align="center">
    <a href="https://augustash.com" target="_blank">
        <picture>
            <source media="(prefers-color-scheme: dark)" srcset="https://augustash.s3.amazonaws.com/logos/ash-inline-invert-500.png">
            <source media="(prefers-color-scheme: light)" srcset="https://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png">
            <img alt="Shows a theme-dependent version of the AAI company logo." src="https://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png">
        </picture>
    </a>
</div>

<div align="center">
    <img src="https://img.shields.io/badge/magento-2.4-brightgreen.svg?logo=magento&longCache=true&style=flat-square" alt="Supported Magento Versions" />
    <a href="https://github.com/augustash/magento2-module-backend/graphs/commit-activity" target="_blank"><img src="https://img.shields.io/badge/maintained%3F-yes-brightgreen.svg?style=flat-square" alt="Maintained - Yes" /></a>
    <a href="https://opensource.org/licenses/MIT" target="_blank"><img src="https://img.shields.io/badge/license-MIT-blue.svg" /></a>
</div>

## Overview

**This is a private module and is not currently aimed at public usage.**

The `Augustash_Backend` module is our base structural module for August Ash functionality. It should be present on all installations.

Functionality provided by this module include:

* Basic configuration block to act as a home for other modules' sections and fields.
* Adds command other code to check if in admin
* Removes customer account links based on configuration.
* Removes the loading of some admin layout blocks to clean up the interface.

## Installation

This module must be installed to use and to configure other August Ash modules. It can be uninstalled after all other August Ash modules are uninstalled.

### Via Composer

Install the extension using Composer from our development package repository:

```bash
composer require augustash/module-backend
bin/magento module:enable --clear-static-content Augustash_Backend
bin/magento setup:upgrade
bin/magento cache:flush
```

## Structure

[Typical file structure for Magento 2 modules](https://developer.adobe.com/commerce/php/development/build/component-file-structure/).
