<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Christian Bergau <cbergau86@gmail.com>
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Collector\RoleCollector,
    CmsPermissions\Identity\ProviderInterface;

/**
 * Factory for building the role collector
 */
class RoleCollectorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return RoleCollector
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $provider ProviderInterface */
        $provider = $serviceLocator->get(ProviderInterface::class);
        return new RoleCollector($provider);
    }
}
