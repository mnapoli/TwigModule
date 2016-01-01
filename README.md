# Twig module for PHP-DI

Pre-configuration for Twig to work with [PHP-DI](http://php-di.org) and [Puli](http://puli.io).

**Experimental:** this module relies on an work-in-progress feature that is not merged in the master branch of PHP-DI yet.

## Installation

To use this module, you need to be using Puli and PHP-DI. To install it, simply require the package with Composer:

```
composer require mnapoli/twig-module
```

PHP-DI will automatically detect and activate the module using Puli (note: *this relies on an experimental feature that is not merged in the master branch of PHP-DI*).

## Usage

The `Twig_Environment` instance is now injectable with PHP-DI.

Templates are loaded through Puli, so you need to use [Puli paths](http://docs.puli.io/en/latest/glossary.html#glossary-puli-path) to render a template (or extend another one).

Example of a Slim controller:

```php
function (ResponseInterface $response, Twig_Environment $twig) {
    $response->getBody()->write($twig->render('/app/views/home.twig'));

    return $response;
}
```

Note the `/app/views/home.twig` Puli path: this expects a file in `res/views/home.twig` and the `res/` directory of your package to be mapped in Puli. Read [Puli's getting started guide](http://docs.puli.io/en/latest/repository/introduction.html) if you are lost.

## Configuration

The following configuration options can be overridden in your PHP-DI config:

- `twig.options`: [Twig options](http://twig.sensiolabs.org/doc/api.html#environment-options)

    ```php
    `twig.options` => [
        'strict_variables' => true,
    ],
    ```
- `twig.extensions`: array of [Twig extensions](http://twig.sensiolabs.org/doc/api.html#using-extensions)

    ```php
    `twig.extensions` => add([
        get(Twig_Extension_Profiler::class),
        get(MyTwigExtension::class),
    ]),
    ```

    Don't forget to *add* items to the array (by using `DI\add()`) to avoid removing the base extensions registered by this module.
