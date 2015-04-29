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
    Zend\ServiceManager\MutableCreationOptionsInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Guard\Route;

/**
 * Factory for building the route guard
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class RouteGuardFactory implements FactoryInterface, MutableCreationOptionsInterface
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

        /* @var $options \CmsAcl\Options\ModuleOptionsInterface */
        $options = $services->get('CmsAcl\\Options\\ModuleOptions');

        /* @var $authorizationService \CmsAcl\Service\AuthorizationServiceInterface */
        $authorizationService = $services->get($options->getAuthorizationService());

        /* @var $assertionPluginManager \Zend\Permissions\Acl\Assertion\AssertionManager */
        $assertionPluginManager = $services->get('Zend\Permissions\Acl\Assertion\AssertionManager');

        return new Route($this->options, $authorizationService, $assertionPluginManager);
    }

    /**
     * {@inheritDoc}
     */
    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }
}
