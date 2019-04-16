# Magento 2 Module - Backend

![https://www.augustash.com](http://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png)

**This is a private module and is not currently aimed at public consumption.**

## Overview

The `Augustash_Backend` module is our base structural module for all August Ash functionality. It must be present on all installations. Functionality provided by this module include:

* Basic administration configuration block for other modules to add sections and fields to.
* Removes the loading of some admin layout blocks to clean up the interface.
* Removes customer account links based on configuration.
* Helper methods for common object CRUD operations

## Installation

This module must be installed to use and to configure the other August Ash modules. It can be uninstalled after all other August Ash modules are uninstalled.

### Via Local Module

Install the extension files directly into the project source:

```bash
mkdir -p app/code/Augustash/Backend/
git archive --format=tar --remote=git@github.com:augustash/magento2-module-backend.git 2.1.0 | tar xf - -C app/code/Augustash/Backend/
bin/magento module:enable --clear-static-content Augustash_Backend
bin/magento setup:upgrade
bin/magento cache:flush
```

### Via Composer

Install the extension using Composer using our development package repository:

```bash
composer config repositories.augustash composer https://packages.augustash.com/repo/private
composer require augustash/module-backend:~2.1.0
bin/magento module:enable --clear-static-content Augustash_Backend
bin/magento setup:upgrade
bin/magento cache:flush
```

## Uninstall

After all dependent modules have also been disabled or uninstalled, you can finally remove this module:

```bash
bin/magento module:disable --clear-static-content Augustash_Backend
rm -rf app/code/Augustash/Backend/
composer remove augustash/module-backend
bin/magento setup:upgrade
bin/magento cache:flush
```

## Structure

[Typical file structure for a Magento 2 module](http://devdocs.magento.com/guides/v2.3/extension-dev-guide/build/module-file-structure.html).
