# Magento 2 Module - Backend

![https://www.augustash.com](http://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png)

**This is a private module and is not currently aimed at public consumption.**

## Overview

The `Augustash_Backend` module is our base structural module for all August Ash functionality. It must be present on all installations. Functionality provided by this module include:

* Basic administration configuration block for other modules to add sections and fields to.
* Removes the loading of some admin layout blocks to clean up the interface.
* Removes customer account links based on configuration.
* Removes reviews/compare based on configuration.
* Registry for the current product.

## Installation

This module must be installed to use and to configure the other August Ash modules. It can be uninstalled after all other August Ash modules are uninstalled.

### Via Composer

Install the extension using Composer using our development package repository:

```bash
composer config repositories.augustash composer https://augustash.repo.repman.io
composer require augustash/module-backend:~4.0.0
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

[Typical file structure for a Magento 2 module](http://devdocs.magento.com/guides/v2.4/extension-dev-guide/build/module-file-structure.html).
