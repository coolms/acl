<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory\Guard;

use Zend\ServiceManager\Config,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsPermissions\Guard\GuardPluginManager;

/**
 * Factory to create a Guard plugin manager
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class GuardPluginManagerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return GuardPluginManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['cmspermissions']['acl']['guard_manager'];

        $pluginManager = new GuardPluginManager(new Config($config));
        $pluginManager->setServiceLocator($serviceLocator);

        return $pluginManager;
    }
}
