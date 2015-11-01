# potato-orm

[![Build Status](https://travis-ci.org/andela-kerinoso/potato-orm.svg)](https://travis-ci.org/andela-kerinoso/potato-orm)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/kola/potato-orm.svg?style=flat-square)](https://packagist.org/packages/kola/potato-orm)
[![Total Downloads](https://img.shields.io/packagist/dt/kola/potato-orm.svg?style=flat-square)](https://packagist.org/packages/kola/potato-orm)


This is an ORM package that manages the persistence of simple database CRUD operations.

## Installation

[PHP](https://php.net) 5.5+ and [Composer](https://getcomposer.org) are required.

Via Composer

``` bash
$ composer require kola/potato-orm
```

``` bash
$ composer install
```

## Usage

Create a class with the name of the corresponding table in the database. Extend the class to the base class `Model` under the namespace `Kola\PotatoOrm`.

For instance, a class for `dogs` or `Dogs` or `dog` or `Dog` table should look like this:

``` php
namespace Kola\PotatoOrm;

class Dog extends Model
{
}
```

* Create and save a record to database

``` php
$dog = new Dog();
$dog->name = "Rex";
$dog->breed= "Alsatian";
$dog->origin = "Germany";
$dog->save();
```

* Find and update a record in database

``` php
$dog = Dog::find(4);
$dog->name = "Bruno";
$dog->save();
```

OR

``` php
$dog = Dog::where('name', 'Rex');
$dog->breed = "Rottweiler";
$dog->save();
```


* Delete a record

``` php
$dog = Dog::destroy(2);
```

Feel free to name the class as the singular of the name of the database table. For instance, `User` class for `users` table.

`Note: Plurals of irregular nouns are not supported`

For instance, a class `Fish` should map to a table `fish` or `fishs`, not `fishes`. And a class `Child` should map to a table `child` or `childs`, not `children`.

## Supported database

Currently, only MYSQL and PostgreSQL are supported.

Work towards the support for other popular databases is in progress.

## Change log

Please check out [CHANGELOG](CHANGELOG.md) file for information on what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit test
```

## Contributing

Please check out [CONTRIBUTING](CONTRIBUTING.md) file for detailed contribution guidelines.

## Credits

potato-orm is maintained by `Kolawole ERINOSO`.

## License

potato-orm is released under the MIT Licence. See the bundled [LICENSE](LICENSE.md) file for details.
