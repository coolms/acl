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

use Zend\ServiceManager\AbstractPluginManager,
    Zend\ServiceManager\InitializerInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\View\Helper\Navigation\AbstractHelper as AbstractNavigationHelper,
    CmsCommon\Permissions\Acl\AclAwareInterface;

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

        if ($serviceLocator->has('Zend\\Permissions\\Acl\\AclInterface')) {
            /* @var $acl \Zend\Permissions\Acl\AclInterface */
            $acl = $serviceLocator->get('Zend\\Permissions\\Acl\\AclInterface');
            $instance::setDefaultAcl($acl);
        }

        if ($serviceLocator->has('CmsPermissions\\Identity\\ProviderInterface')) {
            /* @var $identityProvider \CmsPermissions\Identity\ProviderInterface */
            $identityProvider = $serviceLocator->get('CmsPermissions\\Identity\\ProviderInterface');
            $instance::setDefaultRole($identityProvider->getIdentity());
        }
    }
}
