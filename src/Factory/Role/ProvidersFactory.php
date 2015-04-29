<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory\Role;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory responsible of building a set of {@see \CmsPermissions\Role\ProviderInterface}
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class ProvidersFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \CmsPermissions\Role\ProviderInterface[]|array
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options \CmsPermissions\Options\ModuleOptionsInterface */
        $options = $serviceLocator->get('CmsPermissions\Options\ModuleOptions');
        $providersOptions = $options->getRoleProviders();
        $providers = [];

        if (empty($providersOptions)) {
            return $providers;
        }

        /* @var $pluginManager \CmsPermissions\Role\ProviderPluginManager */
        $pluginManager = $serviceLocator->get('CmsAcl\Role\ProviderPluginManager');

        foreach ($providersOptions as $type => $options) {
            $providers[] = $pluginManager->get($type, $options);
        }

        return $providers;
    }
}
