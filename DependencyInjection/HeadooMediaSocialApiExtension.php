<?php

namespace Headoo\MediaSocialApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HeadooMediaSocialApiExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('headoo_media_social_api.twitter_access.oauth_access_token', $config['twitter_access']['oauth_access_token']);
        $container->setParameter('headoo_media_social_api.twitter_access.oauth_access_token_secret', $config['twitter_access']['oauth_access_token_secret']);
        $container->setParameter('headoo_media_social_api.twitter_access.consumer_key', $config['twitter_access']['consumer_key']);
        $container->setParameter('headoo_media_social_api.twitter_access.consumer_secret', $config['twitter_access']['consumer_secret']);
        $container->setParameter('headoo_media_social_api.instagram_access.access_token', $config['instagram_access']['access_token']);

    }
}
