<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory;

use Zend\Permissions\Acl\Assertion\AssertionManager,
    Zend\ServiceManager\Config,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory to create a assertion plugin manager
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class AssertionPluginManagerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return AssertionManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $assertionManagerConfig = [];
        if (isset($config['cmspermissions']['acl']['assertion_manager'])) {
            $assertionManagerConfig = $config['cmspermissions']['acl']['assertion_manager'];
        }

        $pluginManager = new AssertionManager(new Config($assertionManagerConfig));
        $pluginManager->setServiceLocator($serviceLocator);

        return $pluginManager;
    }
}
