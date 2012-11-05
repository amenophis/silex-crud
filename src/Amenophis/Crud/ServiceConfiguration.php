<?php

namespace Amenophis\Crud;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class ServiceConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('crud');

        $rootNode
            ->children()
                ->arrayNode('list')
                    ->children()
                        ->variableNode('fields')->end()
                    ->end()
                ->end()
                ->arrayNode('fields')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('label')->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('entity')
                    ->defaultNull()
                ->end()
                ->scalarNode('route')
                    ->defaultNull()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}