<?php
/**
 * Platform.sh eZ Legacy Fastly Bundle
 *
 * @author    Sebastien Morel <s.morel@novactive.com>
 * @copyright 2018 Platform.sh
 * @license   Proprietary
 */

namespace Platformsh\EzLegacyFastlyBundle\Listener;

use Platformsh\EzLegacyFastlyBundle\Core\Header;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseListener
{
    /**
     * Tag the Response with the Fastly Header instead of the Varnish one.
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        if ($response->headers->has(Header::VARNISH)) {
            $response->headers->set(Header::FASTLY, $response->headers->get(Header::VARNISH));
            $response->headers->remove(Header::VARNISH);
        }
    }
}
