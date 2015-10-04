# potato-orm

This is an ORM package that manages the persistence of database CRUD operations.

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

For instance, a class for `jobs` table should look like this:

> namespace Kola\PotatoOrm;

> class Job extends Model
> {
> }

Feel free to name the class as the singular of the name of the database table. For instance, `User` class for `users` table.

`Note: Plural of irregular nouns are not supported`

For instance, a class `Fish` should map to a table `Fish`, not `Fishes`. And a class `Child` should map to a table `Child`, not `Children`.

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