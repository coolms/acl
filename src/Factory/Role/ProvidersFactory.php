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
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsPermissions\Options\ModuleOptionsInterface,
    CmsPermissions\Options\ModuleOptions,
    CmsPermissions\Role\ProviderPluginManager;

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
        /* @var $options ModuleOptionsInterface */
        $options = $serviceLocator->get(ModuleOptions::class);
        $providersOptions = $options->getRoleProviders();
        $providers = [];

        if (empty($providersOptions)) {
            return $providers;
        }

        /**
         * @todo Is CmsAcl\Role\ProviderPluginManager correct key?
         */
        /* @var $pluginManager ProviderPluginManager */
        $pluginManager = $serviceLocator->get('CmsAcl\Role\ProviderPluginManager');

        foreach ($providersOptions as $type => $options) {
            $providers[] = $pluginManager->get($type, $options);
        }

        return $providers;
    }
}
