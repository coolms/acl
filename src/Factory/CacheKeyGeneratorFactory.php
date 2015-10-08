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

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Options\ModuleOptionsInterface,
    CmsAcl\Options\ModuleOptions;

/**
 * Factory for building a cache key generator
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class CacheKeyGeneratorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \Closure
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $config ModuleOptionsInterface */
        $options    = $serviceLocator->get(ModuleOptions::class);
        $cacheKey   = $options->getCacheKey() ?: 'cms_acl';

        return function () use ($cacheKey) {
            return $cacheKey;
        };
    }
}
