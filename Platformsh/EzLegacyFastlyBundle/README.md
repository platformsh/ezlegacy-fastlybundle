# Platform.sh eZ Legacy Fastly Bundle

## Install

Register the Bundle in your kernel:

```php
# ezpublish/EzPublishKernel.php

public function registerBundles() {
        ...
        $bundles = array(
            ...
            new Platformsh\EzLegacyFastlyBundle\EzLegacyFastlyBundle()
        );    
        ...
}
```

## Configure

Add the configuration. 

```yaml
ez_legacy_fastly:
    system:
        default:
           fastly_service_id: "xxx"
           fastly_key: "xxx"

```

> That is SiteAccessAware.
