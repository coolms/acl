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

use Zend\Permissions\Acl\Assertion\AssertionManager,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\MutableCreationOptionsInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Rule\InMemoryProvider;

/**
 * Factory responsible of building {@see \CmsAcl\Rule\InMemoryProvider}
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
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
    public function createService(ServiceLocatorInterface $ruleProviders)
    {
        $services = $ruleProviders->getServiceLocator();
        $assertionPluginManager = $services->get(AssertionManager::class);

        return new InMemoryProvider($this->options, $assertionPluginManager);
    }

    /**
     * {@inheritDoc}
     */
    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }
}
