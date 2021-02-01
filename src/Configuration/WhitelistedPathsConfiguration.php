<?php declare(strict_types=1);

namespace Kiboko\Plugin\API\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class WhitelistedPathsConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('whitelisted_paths');

        $builder->getRootNode()
            ->variablePrototype();

        return $builder;
    }
}
