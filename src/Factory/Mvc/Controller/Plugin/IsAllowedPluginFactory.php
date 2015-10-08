<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory\Mvc\Controller\Plugin;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Mvc\Controller\Plugin\IsAllowed,
    CmsAcl\Options\ModuleOptionsInterface,
    CmsAcl\Options\ModuleOptions;

class IsAllowedPluginFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $plugins)
    {
        $parentLocator = $plugins->getServiceLocator();

        /* @var $options ModuleOptionsInterface */
        $options = $parentLocator->get(ModuleOptions::class);
        $authService = $parentLocator->get($options->getAuthorizationService());

        return new IsAllowed($authService);
    }
}
