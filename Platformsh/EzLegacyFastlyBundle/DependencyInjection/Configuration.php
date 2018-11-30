<?php
/**
 * Platform.sh eZ Legacy Fastly Bundle
 *
 * @author    Sebastien Morel <s.morel@novactive.com>
 * @copyright 2018 Platform.sh
 * @license   Proprietary
 */

namespace Platformsh\EzLegacyFastlyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;

class Configuration extends SiteAccessConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('ez_legacy_fastly');
        $systemNode  = $this->generateScopeBaseNode($rootNode);
        $systemNode
            ->scalarNode('fastly_service_id')->isRequired()->end()
            ->scalarNode('fastly_key')->isRequired()->end();

        return $treeBuilder;
    }
}
