README
======

What is this bundle?
--------------------

This Symfony2 bundle prepends, on production enviroment, the folder "dist/app/Resources/views" to
the Twig loader and also force to remove it on development enviroment.

Requirements
------------

I only tested on Symfony 2.3 and 2.4.

Installation
------------

If you are creating a new project I suggest you to use yeoman generator SF2:
https://github.com/diegomarangoni/generator-sf2

If you want to use with an existing project, first you must add the package to your composer.json file:

```json
{
    "require": {
    	...
        "rior/grunt-dist-bundle": "1.0.*@dev",
        ...
    }
}
```

And then run:

```bash
composer update
```

And finally, you must enabled the bundle on your AppKernel.php:

```php
$bundles = array(
    ...
    new Rior\Bundle\GruntDistBundle\RiorGruntDistBundle(),
    ...
);
```

Contributing
------------

Feel free to contact me and to contribute with the code.
