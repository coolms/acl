<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Factory\Resource;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\MutableCreationOptionsInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Resource\InMemoryProvider;

/**
 * Factory responsible of building {@see \CmsAcl\Resource\InMemoryProvider}
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class InMemoryProviderFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * {@inheritDoc}
     *
     * @return InMemoryProvider
     */
    public function createService(ServiceLocatorInterface $roleProviders)
    {
        return new InMemoryProvider($this->options);
    }

    /**
     * {@inheritDoc}
     */
    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }
}
