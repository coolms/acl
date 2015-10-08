<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Initializer;

use Zend\Permissions\Acl\AclInterface,
    Zend\ServiceManager\AbstractPluginManager,
    Zend\ServiceManager\InitializerInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\View\Helper\Navigation\AbstractHelper as AbstractNavigationHelper,
    CmsCommon\Permissions\Acl\AclAwareInterface,
    CmsPermissions\Identity\ProviderInterface;

class AclInitializer implements InitializerInterface
{
    /**
     * {@inheritDoc}
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if (!$instance instanceof AclAwareInterface &&
            !$instance instanceof AbstractNavigationHelper ||
            ($instance->hasAcl() && $instance->hasRole())
        ) {
            return;
        }

        if ($serviceLocator instanceof AbstractPluginManager) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        if ($serviceLocator->has(AclInterface::class)) {
            /* @var $acl AclInterface */
            $acl = $serviceLocator->get(AclInterface::class);
            $instance::setDefaultAcl($acl);
        }

        if ($serviceLocator->has(ProviderInterface::class)) {
            /* @var $identityProvider ProviderInterface */
            $identityProvider = $serviceLocator->get(ProviderInterface::class);
            $instance::setDefaultRole($identityProvider->getIdentity());
        }
    }
}
