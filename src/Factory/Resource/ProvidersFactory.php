<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory\Resource;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory responsible of a set of {@see \CmsAcl\Resource\ProviderInterface}
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class ProvidersFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \CmsAcl\Resource\ProviderInterface[]|array
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options \CmsAcl\Options\ModuleOptionsInterface */
        $options = $serviceLocator->get('CmsAcl\Options\ModuleOptions');
        $providersOptions = $options->getResourceProviders();
        $providers = [];

        if (empty($providersOptions)) {
            return $providers;
        }

        /* @var $pluginManager \CmsAcl\Resource\ProviderPluginManager */
        $pluginManager = $serviceLocator->get('CmsAcl\Resource\ProviderPluginManager');

        foreach ($providersOptions as $type => $options) {
            $providers[] = $pluginManager->get($type, $options);
        }

        return $providers;
    }
}
