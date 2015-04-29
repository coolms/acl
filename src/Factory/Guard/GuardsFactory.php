<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory\Guard;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory responsible of building a set of {@see \CmsPermissions\Guard\GuardInterface}
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class GuardsFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \CmsPermissions\Guard\GuardInterface[]|array
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options \CmsAcl\Options\ModuleOptionsInterface */
        $options = $serviceLocator->get('CmsAcl\Options\ModuleOptions');
        $guardsOptions = $options->getGuards();

        if (empty($guardsOptions)) {
            return [];
        }

        /* @var $pluginManager \CmsAcl\Guard\GuardPluginManager */
        $pluginManager = $serviceLocator->get('CmsAcl\Guard\GuardPluginManager');
        $guards = [];

        foreach ($guardsOptions as $type => $options) {
            $guards[] = $pluginManager->get($type, $options);
        }

        return $guards;
    }
}
