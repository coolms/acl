<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory\Role;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Role\MapperProvider;

/**
 * Factory responsible of building {@see \CmsAcl\Role\MapperProvider}
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class MapperProviderFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \CmsAcl\Role\MapperProvider
     */
    public function createService(ServiceLocatorInterface $roleProviders)
    {
        $services = $roleProviders->getServiceLocator();

        /* @var $options \CmsPermissions\Options\ModuleOptionsInterface */
        $options = $services->get('CmsPermissions\\Options\\ModuleOptions');

        return new MapperProvider($services->get('MapperManager')->get($options->getRoleEntityClass()));
    }
}
