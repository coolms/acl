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

use Zend\ServiceManager\Config,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsPermissions\Role\ProviderPluginManager;

/**
 * Factory to create a Role provider plugin manager
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class ProviderPluginManagerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ProviderPluginManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['cmspermissions']['acl']['role_provider_manager'];

        $pluginManager = new ProviderPluginManager(new Config($config));
        $pluginManager->setServiceLocator($serviceLocator);

        return $pluginManager;
    }
}
