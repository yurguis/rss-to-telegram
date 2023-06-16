<?php
/**
 * @author Yurguis Garcia <yurguis@gmail.com>
 */

namespace TelegramBot\Config;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('config');
        $rootNode    = $treeBuilder->getRootNode();

        $this->addCacheSection($rootNode);
        $this->addTelegramSection($rootNode);
        $this->addFeedsSection($rootNode);

        return $treeBuilder;
    }

    private function addCacheSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('adapter')->defaultValue('filesystem')->end()
                        ->scalarNode('provider')->defaultValue('filesystem')->end()
                        ->scalarNode('namespace')->defaultValue('telegram-bot')->end()
                        ->scalarNode('default_lifetime')->defaultValue(3600)->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addTelegramSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('telegram')
                ->isRequired()
                ->requiresAtLeastOneElement()
                ->useAttributeAsKey('name')
                ->arrayPrototype()
                    ->children()
                        ->integerNode('chat_id')->isRequired()->end()
                        ->scalarNode('topic_id')->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addFeedsSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('feeds')
                ->isRequired()
                ->requiresAtLeastOneElement()
                ->useAttributeAsKey('name')
                ->arrayPrototype()
                    ->children()
                        ->scalarNode('url')->end()
                        ->arrayNode('keyword')
                            ->children()
                                ->arrayNode('title')
                                    ->scalarPrototype()->end()
                                ->end()
                                ->arrayNode('description')
                                    ->scalarPrototype()->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('message')
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}