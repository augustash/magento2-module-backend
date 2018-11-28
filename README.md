# Magento 2 Module - Backend

![https://www.augustash.com](http://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png)

**This is a private module and is not currently aimed at public consumption.**

## Overview

The `Augustash_Backend` module is our base module for all August Ash functionality. It must be present on all installations.

## Installation

This module must be installed to use and to configure the other August Ash modules. It can be uninstalled after all other August Ash modules are uninstalled.

```bash
composer config repositories.augustash composer https://packages.augustash.com/repo/private
composer require augustash/module-backend:1.0.1
```

## Structure

[Typical file structure for a Magento 2 module](http://devdocs.magento.com/guides/v2.3/extension-dev-guide/build/module-file-structure.html).
