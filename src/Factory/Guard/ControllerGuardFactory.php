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

use Zend\Permissions\Acl\Assertion\AssertionManager,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\MutableCreationOptionsInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Guard\Controller,
    CmsAcl\Options\ModuleOptionsInterface,
    CmsAcl\Options\ModuleOptions;

/**
 * Factory for building the controller guard
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class ControllerGuardFactory implements FactoryInterface, MutableCreationOptionsInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $guards)
    {
        $services = $guards->getServiceLocator();

        /* @var $options ModuleOptionsInterface */
        $options = $services->get(ModuleOptions::class);

        /* @var $authorizationService \CmsAcl\Service\AuthorizationServiceInterface */
        $authorizationService = $services->get($options->getAuthorizationService());

        /* @var $assertionPluginManager AssertionManager */
        $assertionPluginManager = $services->get(AssertionManager::class);

        return new Controller($this->options, $authorizationService, $assertionPluginManager);
    }

    /**
     * {@inheritDoc}
     */
    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }
}
