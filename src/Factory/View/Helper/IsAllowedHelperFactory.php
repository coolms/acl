<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Options\ModuleOptionsInterface,
    CmsAcl\Options\ModuleOptions,
    CmsAcl\View\Helper\IsAllowed;

class IsAllowedHelperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return IsAllowed
     */
    public function createService(ServiceLocatorInterface $helpers)
    {
        $services = $helpers->getServiceLocator();

        /* @var $options ModuleOptionsInterface */
        $options = $services->get(ModuleOptions::class);
        /* @var $authorizationService \CmsAcl\Service\AuthorizationServiceInterface */
        $authorizationService = $services->get($options->getAuthorizationService());

        return new IsAllowed($authorizationService);
    }
}
