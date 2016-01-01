# Twig module for PHP-DI

Pre-configuration for Twig to work with PHP-DI.

## Installation

```
composer require mnapoli/twig-module
```

## Usage

The `Twig_Environment` instance is now injectable wherever dependency injection is available.

Templates are loaded through Puli, so you need to use [Puli paths](http://docs.puli.io/en/latest/glossary.html#glossary-puli-path) to render a template (or extend another one).

Example of a Slim controller:

```php
function (ResponseInterface $response, Twig_Environment $twig) {
    $response->getBody()->write($twig->render('/app/views/home.twig'));

    return $response;
}
```

## Configuration

The following configuration options can be customized if needed:

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
