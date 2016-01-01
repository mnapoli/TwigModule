<?php

use Puli\Repository\Api\ResourceRepository;
use Puli\TwigExtension\PuliExtension;
use Puli\TwigExtension\PuliTemplateLoader;
use Puli\UrlGenerator\Api\UrlGenerator;
use function DI\add;
use function DI\get;
use function DI\object;

return [

    /**
     * Twig options
     * @see http://twig.sensiolabs.org/doc/api.html#environment-options
     */
    'twig.options' => [],

    /**
     * Register Twig extensions through this array.
     */
    'twig.extensions' => add([
        get(PuliExtension::class),
    ]),

    Twig_Environment::class => object()
        ->constructor(get(Twig_LoaderInterface::class), get('twig.options'))
        ->method('setExtensions', get('twig.extensions')),

    Twig_LoaderInterface::class => object(PuliTemplateLoader::class),

    PuliExtension::class => object()
        ->constructor(get(ResourceRepository::class), get(UrlGenerator::class)),

];
