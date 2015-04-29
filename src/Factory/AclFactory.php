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

use Zend\Permissions\Acl\Acl,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for building the ACL
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class AclFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return Acl
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options \CmsAcl\Options\ModuleOptionsInterface */
        $options = $serviceLocator->get('CmsAcl\\Options\\ModuleOptions');
        return $serviceLocator->get($options->getAuthorizationService())->getAcl();
    }
}
