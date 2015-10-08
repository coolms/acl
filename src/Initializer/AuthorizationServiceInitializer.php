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
    CmsAcl\Options\ModuleOptionsInterface,
    CmsAcl\Options\ModuleOptions,
    CmsAcl\Service\AuthorizationServiceAwareInterface;

class AuthorizationServiceInitializer implements InitializerInterface
{
    /**
     * {@inheritDoc}
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof AuthorizationServiceAwareInterface) {
            if ($serviceLocator instanceof AbstractPluginManager) {
                $serviceLocator = $serviceLocator->getServiceLocator();
            }

            /* @var $options ModuleOptionsInterface */
            $options = $serviceLocator->get(ModuleOptions::class);
            /* @var $authorizationService \CmsAcl\Service\AuthorizationServiceInterface */
            $authorizationService = $serviceLocator->get($options->getAuthorizationService());
            $instance->setAuthorizationService($authorizationService);
        }
    }
}
