<?php

use DI\ContainerBuilder;
use Puli\Repository\Api\ResourceRepository;
use Puli\Repository\InMemoryRepository;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function creates_a_twig_instance()
    {
        $container = $this->createContainer();
        $this->assertInstanceOf(Twig_Environment::class, $container->get(Twig_Environment::class));
    }

    /**
     * @test
     */
    public function debug_is_disabled_by_default()
    {
        $container = $this->createContainer();

        /** @var Twig_Environment $twig */
        $twig = $container->get(Twig_Environment::class);
        $this->assertFalse($twig->isDebug());
        $this->assertFalse($twig->hasExtension('debug'));
    }

    /**
     * @test
     */
    public function options_can_be_customized()
    {
        $container = $this->createContainer([
            'twig.options' => [
                'strict_variables' => true,
            ],
        ]);

        $expectedOptions = [
            'strict_variables' => true,
        ];
        $this->assertEquals($expectedOptions, $container->get('twig.options'));

        /** @var Twig_Environment $twig */
        $twig = $container->get('Twig_Environment');
        $this->assertTrue($twig->isStrictVariables());
    }

    /**
     * @test
     */
    public function extensions_can_be_registered()
    {
        $container = $this->createContainer([
            'twig.extensions' => DI\add([
                DI\get(Twig_Extension_StringLoader::class),
            ]),
        ]);

        /** @var Twig_Environment $twig */
        $twig = $container->get(Twig_Environment::class);
        $this->assertTrue($twig->hasExtension('string_loader'));
    }

    private function createContainer($definitions = [])
    {
        $builder = new ContainerBuilder;
        $builder->addDefinitions(__DIR__ . '/../res/config/config.php');
        $builder->addDefinitions([
            ResourceRepository::class => new InMemoryRepository,
        ]);
        $builder->addDefinitions($definitions);

        return $builder->build();
    }
}
