<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory\Rule;

use Zend\ServiceManager\Config,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Rule\ProviderPluginManager;

/**
 * Factory to create a Rule provider plugin manager
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
        $config = $serviceLocator->get('Config');

        $providerManagerConfig = [];
        if (isset($config['cmspermissions']['acl']['rule_provider_manager'])) {
            $providerManagerConfig = $config['cmspermissions']['acl']['rule_provider_manager'];
        }

        $pluginManager = new ProviderPluginManager(new Config($providerManagerConfig));
        $pluginManager->setServiceLocator($serviceLocator);

        return $pluginManager;
    }
}
