<?php
/**
 * Platform.sh eZ Legacy Fastly Bundle
 *
 * @author    Sebastien Morel <s.morel@novactive.com>
 * @copyright 2018 Platform.sh
 * @license   Proprietary
 */

namespace Platformsh\EzLegacyFastlyBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class EzLegacyFastlyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $processor = new ConfigurationProcessor($container, 'ez_legacy_fastly');
        $processor->mapSetting('fastly_service_id', $config);
        $processor->mapSetting('fastly_key', $config);
    }
}
