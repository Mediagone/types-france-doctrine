# Types France for  Doctrine

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE)

Provides Doctrine types for "mediagone/types-france" package.


## Installation
This package requires **PHP 7.4+** and Doctrine **DBAL 2.7+**

Add it as Composer dependency:
```sh
$ composer require mediagone/types-france-doctrine
```

### With Symfony
If you're using this package in a Symfony project, register utilized custom types in `doctrine.yaml`:
```yaml
doctrine:
    dbal:
        types:
            app_postalcode: Mediagone\Doctrine\Types\France\Geo\PostalCodeType
            ...
```
_Note: `app_postalcode` being the type name you'll use in your Entity mappings, you can pick whatever name you wish._


### As standalone
Custom types can also be used separately, but need to be registered in Doctrine DBAL like this:
```php
use Doctrine\DBAL\Types\Type;
use Mediagone\Doctrine\Types\France\Geo\PostalCodeType;

Type::addType(PostalCodeType::NAME, PostalCodeType::class);
// or, with a custom name:
Type::addType('app_postalcode', PostalCodeType::class);
```



## License

_Types France for Doctrine_ is licensed under MIT license. See LICENSE file.



[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-version]: https://img.shields.io/packagist/v/mediagone/types-france-doctrine.svg
[ico-downloads]: https://img.shields.io/packagist/dt/mediagone/types-france-doctrine.svg

[link-packagist]: https://packagist.org/packages/mediagone/types-france-doctrine
[link-downloads]: https://packagist.org/packages/mediagone/types-france-doctrine
