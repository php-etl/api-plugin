<?php declare(strict_types=1);

namespace Kiboko\Plugin\API;

use Kiboko\Component\Satellite\NamedConfigurationInterface;
use Kiboko\Plugin\API\Configuration\ContextConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface, NamedConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder($this->getName());

        $builder->getRootNode()
            ->children()
                ->arrayNode('openapi')
                    ->children()
                        ->enumNode('version')->isRequired()->values(['2', '3'])->end()
                        ->scalarNode('path')->isRequired()->end()
                        ->scalarNode('namespace')->isRequired()->end()
                        ->append((new ContextConfiguration())->getConfigTreeBuilder()->getRootNode())
                    ->end()
                ->end()
                ->arrayNode('extractor')
                    ->children()
                        ->scalarNode('endpoint')->isRequired()->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }

    public function getName(): string
    {
        return 'api';
    }
}
