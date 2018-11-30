<?php
/**
 * Platform.sh eZ Legacy Fastly Bundle
 *
 * @author    Sebastien Morel <s.morel@novactive.com>
 * @copyright 2018 Platform.sh
 * @license   Proprietary
 */

namespace Platformsh\EzLegacyFastlyBundle;

use Platformsh\EzLegacyFastlyBundle\DependencyInjection\Compiler\FastlyKernelPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EzLegacyFastlyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FastlyKernelPass());
    }
}
