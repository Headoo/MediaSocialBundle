<?php

namespace Headoo\MediaSocialApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('headoo_media_social_api');
        $rootNode

            ->children()
                ->arrayNode('twitter_access')
                    ->isRequired()
                    ->children()
                        ->scalarNode('oauth_access_token')
                        ->end()
                        ->scalarNode('oauth_access_token_secret')
                        ->end()
                        ->scalarNode('consumer_key')
                        ->end()
                        ->scalarNode('consumer_secret')
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->children()
                ->arrayNode('instagram_access')
                    ->children()
                        ->scalarNode('access_token')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
