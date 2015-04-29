<?php 
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /**
     * Turn off strict options mode
     *
     * @var bool
     */
    protected $__strictMode__ = false;

    /**
     * Resource providers to be used to load all available resources into \Zend\Permissions\Acl\Acl
     * Keys are the provider service names, values are the options to be passed to the provider
     *
     * @var array
     */
    protected $resourceProviders = [];

    /**
     * Rule providers to be used to load all available rules into \Zend\Permissions\Acl\Acl
     * Keys are the provider service names, values are the options to be passed to the provider
     *
     * @var array
     */
    protected $ruleProviders = [];

    /**
     * Guard listeners to be attached to the application event manager
     *
     * @var array
     */
    protected $guards = [];

    /**
     * Key used by the cache for caching the acl
     *
     * @var string
     */
    protected $cacheKey = 'cms_acl';

    /**
     * Authorization service name
     *
     * @var string
     */
    protected $authorizationService = 'CmsAcl\\Service\\AuthorizationServiceInterface';

    /**
     * {@inheritDoc}
     */
    public function setResourceProviders(array $providers)
    {
        $this->resourceProviders = $providers;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getResourceProviders()
    {
        return $this->resourceProviders;
    }

    /**
     * {@inheritDoc}
     */
    public function setRuleProviders(array $providers)
    {
        $this->ruleProviders = $providers;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRuleProviders()
    {
        return $this->ruleProviders;
    }

    /**
     * {@inheritDoc}
     */
    public function setGuards(array $guards)
    {
        $this->guards = $guards;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getGuards()
    {
        return $this->guards;
    }

    /**
     * {@inheritDoc}
     */
    public function setCacheKey($cacheKey)
    {
        $this->cacheKey = $cacheKey;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCacheKey()
    {
        return (string) $this->cacheKey;
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthorizationService($service)
    {
        $this->authorizationService = $service;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthorizationService()
    {
        return $this->authorizationService;
    }
}
