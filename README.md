# Catalog Sort Order Module for Magento 2

[![Latest Stable Version](https://img.shields.io/packagist/v/opengento/module-catalog-sort-order.svg?style=flat-square)](https://packagist.org/packages/opengento/module-catalog-sort-order)
[![License: MIT](https://img.shields.io/github/license/opengento/magento2-catalog-sort-order.svg?style=flat-square)](./LICENSE) 
[![Packagist](https://img.shields.io/packagist/dt/opengento/module-catalog-sort-order.svg?style=flat-square)](https://packagist.org/packages/opengento/module-catalog-sort-order/stats)
[![Packagist](https://img.shields.io/packagist/dm/opengento/module-catalog-sort-order.svg?style=flat-square)](https://packagist.org/packages/opengento/module-catalog-sort-order/stats)

This module allows to setup the sort direction options in the storefront catalog view.

 - [Setup](#setup)
   - [Composer installation](#composer-installation)
   - [Setup the module](#setup-the-module)
 - [Features](#features)
 - [Settings](#settings)
 - [Documentation](#documentation)
 - [Support](#support)
 - [Authors](#authors)
 - [License](#license)

## Setup

Magento 2 Open Source or Commerce edition is required.

### Composer installation

Run the following composer command:

```
composer require opengento/module-catalog-sort-order
```

### Setup the module

Run the following magento command:

```
bin/magento setup:upgrade
```

**If you are in production mode, do not forget to recompile and redeploy the static resources.**

## Features

Enable advanced catalog list sort by feature.  
Setup the sort options, add the attributes for sort by based on the scope (global/website/store view).  
You can also override the sort option and define if the direction must be included in the label or not.  
If you choose to not include the direction, then the default direction is ascending.  
You can also set the position of the orders in the sort by.  

## Documentation

Settings are available at:

- `Stores > Configuration > Catalog > Catalog > Storefront > Advanced Sort By`
- `Stores > Configuration > Catalog > Catalog > Storefront > Product Listing Sort Options`

## Support

Raise a new [request](https://github.com/opengento/magento2-catalog-sort-order/issues) to the issue tracker.

## Authors

- **Opengento Community** - *Lead* - [![Twitter Follow](https://img.shields.io/twitter/follow/opengento.svg?style=social)](https://twitter.com/opengento)
- **Thomas Klein** - *Maintainer* - [![GitHub followers](https://img.shields.io/github/followers/thomas-kl1.svg?style=social)](https://github.com/thomas-kl1)
- **Contributors** - *Contributor* - [![GitHub contributors](https://img.shields.io/github/contributors/opengento/magento2-catalog-sort-order.svg?style=flat-square)](https://github.com/opengento/magento2-catalog-sort-order/graphs/contributors)

## License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE) details.

***That's all folks!***
