<?php
/**
 * Platform.sh eZ Legacy Fastly Bundle
 *
 * @author    Sebastien Morel <s.morel@novactive.com>
 * @copyright 2018 Platform.sh
 * @license   Proprietary
 */

namespace Platformsh\EzLegacyFastlyBundle\DependencyInjection\Compiler;

use InvalidArgumentException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FastlyKernelPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ezpublish.http_cache.cache_manager')) {
            return;
        }

        if (!$container->hasDefinition('platformsh.ez_legacy.fastly.proxy_client')) {
            throw new InvalidArgumentException('Fastly proxy client must be found.');
        }

        // Forcing cache manager to use Fastly proxy client
        $cacheManagerDef = $container->findDefinition('ezpublish.http_cache.cache_manager');
        $cacheManagerDef->replaceArgument(0, new Reference('platformsh.ez_legacy.fastly.proxy_client'));
    }
}
