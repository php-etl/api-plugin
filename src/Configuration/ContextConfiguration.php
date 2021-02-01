<?php declare(strict_types=1);

namespace Kiboko\Plugin\API\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class ContextConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('context');

        $builder->getRootNode()
            ->children()
                ->booleanNode('reference')->end()
                ->scalarNode('date_format')->end()
                ->scalarNode('full_date_format')->end()
                ->booleanNode('date_prefer_interface')->end()
                ->scalarNode('date_input_format')->end()
                ->booleanNode('strict')->end()
                ->booleanNode('use_fixer')->end()
                ->scalarNode('fixer_config_file')->end()
                ->booleanNode('clean_generated')->end()
                ->booleanNode('use_cacheable_supports_method')->end()
                ->booleanNode('skip_null_values')->end()
                ->booleanNode('skip_required_fields')->end()
                ->append((new WhitelistedPathsConfiguration())->getConfigTreeBuilder()->getRootNode())
                ->scalarNode('endpoint_generator')->end()
                ->scalarNode('custom_query_resolver')->end()
                ->scalarNode('throw_unexpected_status_code')->end()
            ->end()
            ;

        return $builder;
    }
}
