<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory\Rule;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory responsible of a set of {@see \CmsAcl\Rule\ProviderInterface}
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class ProvidersFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \CmsAcl\Rule\ProviderInterface[]|array
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options \CmsAcl\Options\ModuleOptionsInterface */
        $options = $serviceLocator->get('CmsAcl\\Options\\ModuleOptions');
        $providersOptions = $options->getRuleProviders();
        $providers = [];

        if (empty($providersOptions)) {
            return $providers;
        }

        /* @var $pluginManager \CmsAcl\Rule\ProviderPluginManager */
        $pluginManager = $serviceLocator->get('CmsAcl\\Rule\\ProviderPluginManager');

        foreach ($providersOptions as $type => $options) {
            $providers[] = $pluginManager->get($type, $options);
        }

        return $providers;
    }
}
