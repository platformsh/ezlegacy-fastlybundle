<?php
/**
 * Platform.sh eZ Legacy Fastly Bundle
 *
 * @author    Sebastien Morel <s.morel@novactive.com>
 * @copyright 2018 Platform.sh
 * @license   Proprietary
 */

namespace Platformsh\EzLegacyFastlyBundle\Core\ProxyClient;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use FOS\HttpCache\ProxyClient\AbstractProxyClient;
use FOS\HttpCache\ProxyClient\Invalidation\BanInterface;
use FOS\HttpCache\ProxyClient\Invalidation\PurgeInterface;
use Platformsh\EzLegacyFastlyBundle\Core\Header;

class Fastly extends AbstractProxyClient implements BanInterface, PurgeInterface
{

    /**
     * @var string
     */
    private $serviceId;

    /**
     * @var string
     */
    private $serviceKey;

    /**
     * @var ConfigResolverInterface
     */
    private $configResolver;

    public function setConfigResolver(ConfigResolverInterface $configResolver)
    {
        $this->configResolver = $configResolver;

        return $this->setFastlyCredentials(
            $this->configResolver->getParameter('fastly_service_id', 'ez_legacy_fastly'),
            $this->configResolver->getParameter('fastly_key', 'ez_legacy_fastly')
        );
    }

    public function setFastlyCredentials($id, $key)
    {
        $this->serviceId  = $id;
        $this->serviceKey = $key;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function ban(array $headers)
    {
        if (isset($headers[Header::VARNISH])) {
            // (2|1|1235|1627|1632|1641|1629)
            $locationIds = explode("|", trim(trim($headers[Header::VARNISH], '(|)')));
            unset($headers[Header::VARNISH]);

            if ($locationIds[0] === '.*') {
                // we don't do anything on purpose
                return $this;
            }

            $headers[Header::FASTLY] = implode(
                ' ',
                /*array_map(
                    function ($id) {
                        return "location-{$id}";
                    },
                    $locationIds
                )*/
                $locationIds
            );
            $this->queueRequest('POST', "/service/{$this->serviceId}/purge", $headers);

        }

        return $this;
    }

    public function banPath($path, $contentType = null, $hosts = null)
    {
        // not implemented
        return $this;
    }

    public function purge($url, array $headers = array())
    {
        // not implemented
        return $this;
    }

    protected function createRequest($method, $url, array $headers = array())
    {
        $headers['Fastly-Soft-Purge'] = '0';
        $headers['Fastly-Key']        = $this->serviceKey;
        $headers['Content-Type']      = 'application/json';
        $headers['Accept']            = 'application/json';

        return parent::createRequest($method, $url, $headers);
    }

    protected function getAllowedSchemes()
    {
        return array('https');
    }
}
